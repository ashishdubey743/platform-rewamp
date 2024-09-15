<?php

namespace App\Helpers\Experiment;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ExperimentAPI
{
    /**
     * Fetch tracking metrics from the API based on randomization
     */
    public static function fetchTrackingMetrics(string $type): array
    {
        $response = self::makeEngineApiRequest('GET', self::engineApiUrl('metrics', ['type' => Str::lower($type)]));

        if ($response->failed() || $response->collect()->isEmpty()) {
            return [
                'status' => false,
                'message' => 'Tracking metrics not found.',
            ];
        }

        return [
            'status' => true,
            'message' => 'Tracking metrics found.',
            'data' => $response->collect(),
        ];
    }

    /**
     * Fetch Strata groups from the API based on randomization
     */
    public static function fetchStrataGroups(string $type, bool $requiredStrata = false): array
    {
        $response = self::makeEngineApiRequest('GET', self::engineApiUrl('strata', ['type' => Str::lower($type)]));

        if ($response->failed() || $response->collect()->isEmpty()) {
            return [
                'status' => false,
                'message' => 'Strata not found.',
            ];
        }

        $strataGroups = $response->collect()->when(! $requiredStrata, function ($collection) {
            return $collection->pluck('strata_group')->map([Str::class, 'title'])->unique()->filter()->values();
        }, function ($collection) {
            return $collection->map(function ($value) {
                $value['strata_group'] = Str::title($value['strata_group']);

                return $value;
            });
        });

        return [
            'status' => true,
            'message' => 'Strata found.',
            'data' => $strataGroups,
        ];
    }

    /**
     * Fetch Audience filter from the API based on randomization
     */
    public static function fetchAudienceFilters(string $type): array
    {
        $audienceFilters = collect([]);
        $response = self::makeEngineApiRequest('GET', self::engineApiUrl('filters', ['type' => Str::lower($type)]));

        if ($response->failed() || $response->collect()->isEmpty()) {
            return [
                'status' => false,
                'message' => 'Strata not found.',
            ];
        }

        $audienceFilterFields = self::fetchAudienceFilterFields();
        $audienceFilters = $response->collect()->map(function ($value) use ($audienceFilterFields) {
            $audienceFilterField = $audienceFilterFields->firstWhere('filter_name', $value['filter_name']);

            return $value + [
                'field_type' => $audienceFilterField['field_type'] ?? null,
                'default' => $audienceFilterField['default'] ?? null,
            ];
        })->filter();

        return [
            'status' => true,
            'message' => 'Strata found.',
            'data' => $audienceFilters,
        ];
    }

    /**
     * Run experiment power check
     */
    public static function runPowerCheck(array $apiPayload): array
    {
        $response = self::makeEngineApiRequest('POST', self::engineApiUrl('power'), $apiPayload);
        if ($response->failed() || $response->collect()->isEmpty()) {
            return [
                'status' => false,
                'message' => 'Experiment Power check failed.',
            ];
        }

        return [
            'status' => true,
            'message' => 'Experiment Power check success.',
            'data' => $response->collect(),
        ];
    }

    /**
     * Experiment Assignment
     */
    public static function assignment(int $numberOfUnits, array $apiPayload): array
    {
        $response = self::makeEngineApiRequest('POST', self::engineApiUrl('assign', ['chosen_n' => $numberOfUnits]), $apiPayload);

        if ($response->failed() || $response->collect()->isEmpty()) {
            return [
                'status' => false,
                'message' => 'Experiment assignment failed.',
            ];
        }

        return [
            'status' => true,
            'message' => 'Experiment assignment success.',
            'data' => $response->collect(),
        ];
    }

    /**
     * Create an experiment
     */
    public static function create(string $user, array $apiPayload): array
    {
        $response = self::makeEngineApiRequest('POST', self::engineApiUrl('commit', ['user_id' => $user]), $apiPayload);
        if ($response->failed() || ! $response->json('status') || ! $response->json('data')) {
            return [
                'status' => false,
                'message' => 'Experiment creation failed.',
            ];
        }

        return [
            'status' => true,
            'message' => 'Experiment creation success.',
            'data' => $response->collect('data'),
        ];
    }

    /**
     * Get experiment assignment csv url
     */
    public static function fetchAssignmentCsvUrl(string $experimentId): array
    {
        $response = self::makeApiRequest('GET', self::apiUrl('get-file-name-by-experiment-id/'.$experimentId));

        if ($response->failed() || ! $response->json('status') || ! $response->json('data')) {
            return [
                'status' => false,
                'message' => 'Experiment assignment file not found.',
            ];
        }

        return [
            'status' => true,
            'message' => 'Experiment assignment file found.',
            'data' => $response->collect('data'),
        ];
    }

    /**
     * Update an experiment details
     */
    public static function update(array $apiPayload): array
    {
        $response = self::makeApiRequest('PUT', self::apiUrl('update-experiment-commit'), $apiPayload);

        if ($response->failed() || ! $response->json('status')) {
            return [
                'status' => false,
                'message' => 'Failed to update experiment details.',
            ];
        }

        return [
            'status' => true,
            'message' => 'Experiment details updated successfully.',
        ];
    }

    /**
     * Update experiment start/stop timestamp
     */
    public static function action(array $apiPayload, string $action): array
    {
        $response = self::makeApiRequest('PUT', self::apiUrl('update-timestamps-for-experiment'), $apiPayload);

        if ($response->failed() || ! $response->json('status')) {
            return [
                'status' => false,
                'message' => 'Failed to '.$action.' experiment.',
            ];
        }

        return [
            'status' => true,
            'message' => 'Experiment '.$action.' successfully.',
            'data' => $response->collect('data'),
        ];
    }

    /**
     * Get audience filter fields from local JSON file.
     *
     * @throws FileNotFoundException
     */
    public static function fetchAudienceFilterFields(): Collection
    {
        $fields = File::get(public_path('experiments.json'));
        $fields = json_decode($fields, true);

        return collect($fields['audience_filters']['fields']);
    }

    /**
     * Get the experiment engine API url from config file
     */
    public static function engineApiUrl(?string $path = '', array $parameters = []): string
    {
        return config('custom.ab_experiment_engine_api_url').
            ($path ? '/'.$path : '').
            ($parameters ? '?'.Arr::query($parameters) : '');
    }

    /**
     * Backend (MongoDB) API urls
     */
    public static function apiUrl(?string $path = ''): string
    {
        if (App::isProduction()) {
            return 'https://ab.api.rocketlearning.app/prod/api/v1/experiment-commit'.($path ? '/'.$path : '');
        }

        return 'https://ab.api.rocketlearning.app/dev/api/v1/experiment-commit'.($path ? '/'.$path : '');
    }

    /**
     * Get the experiment mongodb API authentication token
     */
    private static function apiAuthToken(): ?string
    {
        return config('custom.backend_api_token');
    }

    /**
     * Make Backend API request using HTTP requests.
     */
    private static function makeApiRequest(string $method, string $url, array $apiPayload = []): mixed
    {
        $response = Http::acceptJson()
            ->asJson()
            ->withToken(self::apiAuthToken())
            ->timeout(200)
            ->retry(5, 1000)
            ->when($apiPayload, function ($request) use ($apiPayload) {
                $request->withBody(json_encode($apiPayload), 'application/json');
            });

        /* While using retry in HTTP client, an exception will be thrown if the 5 attempts fail, or a timeout occurs.
        But I just want the response object returned. With the rescue() wrapper around the HTTP request,
        It's always receive a response object and can safely go ahead to verify its status. */

        $response = rescue(function () use ($response, $method, $url) {

            if ($method == 'GET') {
                $response = $response->get($url);
            } elseif ($method == 'PUT') {
                $response = $response->put($url);
            } else {
                $response = $response->post($url);
            }

            return $response;
        }, function ($e) {
            return $e->response;
        });
        $response->throwIf($response->status() >= 500);

        return $response;
    }

    /**
     * Make an Experiment Engine API request using HTTP requests.
     */
    private static function makeEngineApiRequest(string $method, string $url, array $apiPayload = []): mixed
    {
        $response = Http::acceptJson()
            ->timeout(200)
            ->retry(5, 1000)
            ->when($apiPayload, function ($request) use ($apiPayload) {
                $request->withBody(json_encode($apiPayload), 'application/json');
            });

        /* While using retry in HTTP client, an exception will be thrown if the 5 attempts fail, or a timeout occurs.
        But I just want the response object returned. With the rescue() wrapper around the HTTP request,
        It's always receive a response object and can safely go ahead to verify its status. */

        $response = rescue(function () use ($response, $method, $url) {

            if ($method == 'GET') {
                $response = $response->get($url);
            } else {
                $response = $response->post($url);
            }

            return $response;
        }, function ($e) {
            return $e->response;
        });
        $response->throwIf($response->status() >= 500);

        return $response;
    }
}
