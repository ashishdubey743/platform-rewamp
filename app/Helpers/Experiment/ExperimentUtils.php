<?php

namespace App\Helpers\Experiment;

use App\Models\Experiment;
use App\Models\Groups;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class ExperimentUtils
{
    /* Experiment Statuses */
    const int DRAFT = 0;

    const int NOT_STARTED = 1;

    const int RUNNING = 2;

    const int STOPPED = 3;

    /**
     * Sync tracking metrics based on inputs
     */
    public static function syncTrackingMetrics(Experiment $experiment, array $trackingMetrics): void
    {
        // Get the current metric IDs associated with the experiment
        $currentMetrics = $experiment->trackingMetrics->pluck('tracking_metric')->toArray();

        // Determine the IDs to be added and removed
        $newMetrics = array_diff($trackingMetrics, $currentMetrics);
        $removedMetrics = array_diff($currentMetrics, $trackingMetrics);

        // If there are no changes, return the existing metric IDs
        if (empty($newMetrics) && empty($removedMetrics)) {
            return;
        }

        // Remove metrics that are no longer selected
        if (! empty($removedMetrics)) {
            $experiment->trackingMetrics()->whereIn('tracking_metric', $removedMetrics)->delete();
        }

        // Add new metrics
        if (! empty($newMetrics)) {

            $newMetricsData = collect($trackingMetrics)
                ->reject(function ($trackingMetric) use ($currentMetrics) {
                    return in_array($trackingMetric, $currentMetrics);
                })
                ->map(function ($trackingMetric) {
                    return [
                        'tracking_metric' => $trackingMetric,
                    ];
                })
                ->filter()
                ->toArray();
            $experiment->trackingMetrics()->createMany($newMetricsData);
        }
    }

    /**
     * Sync strata groups based on inputs
     */
    public static function syncStrataGroups(Experiment $experiment, array $strataGroups): void
    {
        // Get the current strata groups associated with the experiment
        $currentStrataGroups = $experiment->strataGroups->pluck('strata_group')->toArray();

        // Determine the groups to be added and removed
        $newStrataGroups = array_diff($strataGroups, $currentStrataGroups);
        $removedStrataGroups = array_diff($currentStrataGroups, $strataGroups);

        // If there are no changes, then no need further actions.
        if (empty($newStrataGroups) && empty($removedStrataGroups)) {
            return;
        }

        // Remove metrics that are no longer selected
        if (! empty($removedStrataGroups)) {
            $experiment->strataGroups()->whereIn('strata_group', $removedStrataGroups)->delete();
        }

        // Add new strata group
        if (! empty($newStrataGroups)) {
            $newStrataGroupData = collect($strataGroups)
                ->reject(function ($strataGroup) use ($currentStrataGroups) {
                    // Remove the stratas from collection which is already exists.
                    return in_array($strataGroup, $currentStrataGroups);
                })
                ->map(function ($strataGroup) {
                    return ['strata_group' => $strataGroup];
                })
                ->toArray();
            $experiment->strataGroups()->createMany($newStrataGroupData);
        }
    }

    /**
     * Sync audience filters based on inputs
     *
     * @throws Throwable
     */
    public static function syncAudienceFilters(Experiment $experiment, array $currentAudienceFilters): void
    {
        // Fetch audience filter from the API based on randomization
        $audienceFilters = ExperimentAPI::fetchAudienceFilters($experiment->randomization);
        throw_if(! $audienceFilters['status'], $audienceFilters['message']);

        // Delete audience filter which is removed
        $experiment->audienceFilters()->whereNotIn('filter_name', array_keys($currentAudienceFilters))->delete();

        if ($currentAudienceFilters) {
            /* Iterate through the audience filter input and check if the audience filter already exists. If it does, update the filter; otherwise, create the filter. */
            collect($currentAudienceFilters)->each(function ($filterValue, $filterKey) use ($audienceFilters, $experiment) {
                // Retrieve the filter details from API response.
                $audienceFilter = $audienceFilters['data']->where('filter_name', $filterKey)->first();
                if ($audienceFilter) {
                    $fieldType = $audienceFilter['field_type'];
                    $dataType = $audienceFilter['data_type'];
                    $filterName = $audienceFilter['filter_name'];

                    /* Uses updateOrCreate to either update an existing filter or create a new one. Uses array_filter to
                    remove null entries
                        - value : single value (single select or text field)
                        - values : array of values (JSON) (Multiselect)
                     */
                    $experiment->audienceFilters()->updateOrCreate([
                        'filter_name' => $filterName,
                    ], array_filter([
                        'data_type' => $dataType,
                        'value' => $fieldType != 'multiselect' && $filterName != 'experiment_exclude' ? $filterValue : null,
                        'values' => $fieldType == 'multiselect' || $filterName == 'experiment_exclude' ? $filterValue : null,
                    ]));
                }
            });
        }
    }

    /**
     * Sync experiment arms based on inputs
     */
    public static function syncArms(Experiment $experiment, Collection $arms): void
    {
        // Get the existing experiment arms
        $existingArms = $experiment->arms;
        $newArms = [];

        // Iterate through the new descriptions and update or create records
        foreach ($arms as $index => $arm_name) {
            if (isset($existingArms[$index])) {
                // Update the existing arm
                $existingArms[$index]->update(['arm_name' => $arm_name]);
            } else {
                $newArms[] = [
                    'arm_name' => $arm_name,
                ];
            }
        }

        // Create a new arm
        if ($newArms) {
            $experiment->arms()->createMany($newArms);
        }

        // If there are more existing records than new descriptions, delete the extras
        if ($existingArms->count() > $arms->count()) {
            $deletedArms = $existingArms->slice($arms->count())->pluck('id')->toArray();
            $experiment->arms()->whereIn('id', $deletedArms)->delete();
        }
    }

    /**
     * Power check and assign both uses same payload so using it for both of them.
     *
     * @return array[]
     *
     * @throws Throwable
     */
    public static function makePowerCheckPayload(Experiment $experiment): array
    {
        $experiment->load([
            'arms:experiment_id,arm_id,arm_name',
            'trackingMetrics:experiment_id,tracking_metric',
            'strataGroups:experiment_id,strata_group',
            'audienceFilters:experiment_id,filter_name,data_type,value,values',
        ]);

        // Map metrics according to the payload
        $metrics = $experiment->trackingMetrics->pluck('tracking_metric')
            ->map(function ($value) use ($experiment) {
                return ['metric_name' => $value, 'metric_pct_change' => round($experiment->target_metric_movement / 100, 2)];
            })->toArray();

        // Map stratas according to the payload
        $stratas = ExperimentAPI::fetchStrataGroups($experiment->randomization, true);
        throw_if(! $stratas['status'], $stratas['message']);

        $strata_groups = $experiment->strataGroups->pluck('strata_group')->toArray();
        $stratas = $stratas['data']->whereIn('strata_group', $strata_groups)->pluck('column_name')->toArray();

        // Map audience filter object according to the filter field type and payload
        $audienceFilterFields = ExperimentAPI::fetchAudienceFilterFields();
        $audienceFilters = ExperimentAPI::fetchAudienceFilters($experiment->randomization);
        throw_if(! $audienceFilters['status'], $audienceFilters['message']);

        $experimentAudienceFilters = $experiment->audienceFilters->map(function ($filterValue) use ($audienceFilterFields, $audienceFilters) {
            $audienceFilterField = $audienceFilterFields->firstWhere('filter_name', $filterValue->filter_name);
            $audienceFilter = $audienceFilters['data']->firstWhere('filter_name', $filterValue->filter_name);

            if ((! $audienceFilterField || ! $audienceFilter || $filterValue->value == 'All') && $filterValue->filter_name != 'experiment_exclude') {
                return null;
            }

            $filterName = $filterValue->filter_name;
            $value = $filterValue->value ?? $filterValue->values;
            $relation = ($filterName == 'experiment_exclude') ? 'excludes'
                : (in_array($audienceFilterField['field_type'], ['select', 'multiselect']) ? 'includes' : 'between');

            /* If the Filter type is date range than calculate the date range from value and validate the dates
            accordingly. */
            if (in_array('between', $audienceFilter['relations']) && isset($audienceFilterField['is_date_range'])) {
                $minDate = Carbon::createFromFormat('Y-m-d H:i:s', $audienceFilter['min']);
                $maxDate = Carbon::createFromFormat('Y-m-d H:i:s', $audienceFilter['max']);

                // Calculate the target date
                $targetMinDate = $maxDate->copy()->subDays($value);

                // Check if the target date is less than the specified min date
                if ($targetMinDate->lessThan($minDate)) {
                    throw new Exception('The specified minimum date for '.$filterName.' is '.$minDate->format('d/m/Y H:i:s'));
                }
                $value = [
                    $targetMinDate->format('Y-m-d H:i:s'),
                    $maxDate->format('Y-m-d H:i:s'),
                ];
            }

            return [
                'filter_name' => $filterName,
                'relation' => $relation,
                'value' => ! is_array($value) ? [$value] : $value,
            ];
        })->filter()->values()->toArray();

        $apiPayload = [
            'design_spec' => [
                'experiment_id' => $experiment->experiment_uuid,
                'experiment_name' => $experiment->name,
                'description' => $experiment->hypothesis,
                'arms' => $experiment->arms->map(fn ($value) => [
                    'arm_id' => $value->arm_id,
                    'arm_name' => $value->arm_name,
                ])->toArray(),
                'start_date' => $experiment->start_date->format('Y-m-d'),
                'end_date' => $experiment->end_date->format('Y-m-d'),
                'strata_cols' => $stratas,
                'strata_groups' => $strata_groups,
                'power' => 0.8,
                'alpha' => 0.05,
                'fstat_thresh' => 0.5,
                'metrics' => $metrics,
            ],
            'audience_spec' => [
                'type' => strtolower($experiment->randomization),
                'filters' => $experimentAudienceFilters,
            ],
        ];

        return $apiPayload;
    }

    /**
     * Experiment create Payload.
     *
     * @return array[]
     *
     * @throws Throwable
     */
    public static function makeCreatePayload(Experiment $experiment): array
    {
        $apiPayload = self::makePowerCheckPayload($experiment);
        $apiPayload['experiment_assignment'] = $experiment->assignments;

        return $apiPayload;
    }

    /**
     * Get dropdown selectors from JSON file.
     *
     * @return array[]
     */
    public static function getDropdownSelectors(): array
    {
        $dropdownSelectors = json_decode(file_get_contents(base_path('public/drop_down_selector.json')), true);
        $randomization = $dropdownSelectors['experiments']['randomization'] ?? [];
        $productTypes = $dropdownSelectors['experiments']['product_types'] ?? [];
        $institutionTypes = $dropdownSelectors['experiments']['institution_types'] ?? [];
        $userTypes = $dropdownSelectors['experiments']['user_types'] ?? [];

        return [$randomization, $productTypes, $institutionTypes, $userTypes];
    }

    /**
     *  Count experiment groups by various criteria.
     *  This function calculates the count of experiment groups based on the specified criteria:
     *  organization_id, tr_status, class, and group_type. It accepts an array of group IDs and
     *  returns collection containing the count of experiment groups grouped by organization_id,
     *  tr_status, class, and group_type.
     */
    public static function experimentGroupsCount(Collection $groupIds): Collection
    {
        /**
         * The live connection is for the development environment only, for testing purposes.
         * The group_id received from the experiment engine API matches the group IDs in the live database.
         * Therefore, it's necessary to connect to the live database to retrieve group details in the development environment.
         */
        if (App::environment('development')) {
            // Define the live connection parameters
            $liveConnection = [
                'driver' => config('database.connections.mysql.driver'),
                'host' => config('database.connections.mysql.host'),
                'database' => 'live',
                'port' => config('database.connections.mysql.port'),
                'username' => config('database.connections.mysql.username'),
                'password' => config('database.connections.mysql.password'),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
            ];
            Config::set('database.connections.live_connection', $liveConnection);
            DB::reconnect('live_connection');
        }

        $organizationCounts = Groups::on(App::environment('development') ? 'live_connection' : 'mysql')
            ->whereIn('groups.id', $groupIds)
            ->select('organizations.name as key', DB::raw('count(*) as count'), DB::raw('"organization" as type'))
            ->join('organizations', 'organizations.id', '=', 'groups.organization_id')
            ->groupBy('organization_id');

        $classCounts = Groups::on(App::environment('development') ? 'live_connection' : 'mysql')
            ->whereIn('id', $groupIds)
            ->select('class as key', DB::raw('count(*) as count'), DB::raw('"class" as type'))
            ->groupBy('class');

        $trStatusCounts = Groups::on(App::environment('development') ? 'live_connection' : 'mysql')
            ->whereIn('id', $groupIds)
            ->select('tr_status as key', DB::raw('count(*) as count'), DB::raw('"tr_status" as type'))
            ->groupBy('tr_status');

        $typeCounts = Groups::on(App::environment('development') ? 'live_connection' : 'mysql')
            ->whereIn('id', $groupIds)
            ->select('type as key', DB::raw('count(*) as count'), DB::raw('"type" as type'))
            ->groupBy('type');

        $counts = $organizationCounts
            ->unionAll($trStatusCounts)
            ->unionAll($classCounts)
            ->unionAll($typeCounts)
            ->get()
            ->groupBy('type');

        if (App::environment('development')) {
            DB::purge('live_connection');
        }

        // Replace null values with specific values
        $counts = $counts->map(function ($value, $key) {
            if (in_array($key, ['class', 'tr_status'])) {
                $nullValues = $value->whereIn('key', [null, 'NULL', 'null']);
                $value->forget($nullValues->keys()->toArray());
                if ($nullValues->sum('count') > 0) {
                    $value->push((object) [
                        'key' => $key == 'class' ? 'Unclassified' : 'No TR Status',
                        'count' => $nullValues->sum('count'),
                        'type' => $key,
                    ]);
                }
            }

            return $value;
        });

        return $counts;
    }

    /**
     * Generate html badge according to status
     */
    public static function statusHtml(int $status): string
    {
        if ($status == self::NOT_STARTED) {
            $html = '<span class="badge badge-primary">Not Started</span>';
        } elseif ($status == self::RUNNING) {
            $html = '<span class="badge badge-success">Running</span>';
        } elseif ($status == self::STOPPED) {
            $html = '<span class="badge badge-danger">Stopped</span>';
        } else {
            $html = '<span class="badge badge-secondary">Draft</span>';
        }

        return $html;
    }

    /**
     * Convert status text to status value
     */
    public static function getStatusValueFromText(mixed $text): ?int
    {
        $statusMapping = [
            'Not Started' => self::NOT_STARTED,
            'Running' => self::RUNNING,
            'Stopped' => self::STOPPED,
            'Draft' => self::DRAFT,
        ];

        return $statusMapping[Str::title($text)] ?? null;
    }
}
