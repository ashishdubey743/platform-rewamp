<?php

namespace App\Livewire;

use App\Models\VNumbers;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class Vnumber extends Component
{
    use WithPagination, Toast;

    public $perPage = 10;
    public $perPageValues = [10, 20, 30];
    public array $sortBy = ['column' => 'organization', 'direction' => 'desc'];
    public $search_text = '';
    public $headers = [
        ['key' => 'organization', 'label' => 'Organization'],
        ['key' => 'vnumber', 'label' => 'Phone'],
        ['key' => 'type', 'label' => 'Type'],
        ['key' => 'instanceId', 'label' => 'Instance'],
        ['key' => 'initialize', 'label' => 'Initialized'],
        ['key' => 'expiry_date', 'label' => 'Expiry Date'],
        ['key' => 'remaining_days', 'label' => 'Remaining Days'],
        ['key' => 'status', 'label' => 'Status'],
        ['key' => 'blocked', 'label' => 'Blocked'],
        ['key' => 'groupsExtract', 'label' => 'Groups Extract'],
    ];

    // Resets the pagination to the first page when search_text changes
    public function search()
    {
        $this->resetPage();
    }

    // Query method to fetch virtual numbers with search and filters
    public function query(VNumbers $model)
    {
        return $model->newQuery()
            ->leftJoin('organization_vnumber', 'v_numbers.vnumber', '=', 'organization_vnumber.vnumber')
            ->leftJoin('organizations', 'organization_vnumber.organizations_id', '=', 'organizations.id')
            ->selectRaw(
                'v_numbers.vnumber as vnumber,
                v_numbers.active,
                v_numbers.blocked as blocked,
                v_numbers.initialize as initialize,
                v_numbers.type as type,
                v_numbers.API_Token,
                v_numbers.API_InstanceID as instanceId,
                v_numbers.API_Url,
                GROUP_CONCAT(Distinct(organizations.name) SEPARATOR \', \') as organization'
            )
            ->where('organizations.deleted_at', '=', null)
            ->when($this->search_text, function ($query) {
                $query->where(function ($q) {
                    $q->where('v_numbers.vnumber', 'like', '%' . $this->search_text . '%')
                      ->orWhere('organizations.name', 'like', '%' . $this->search_text . '%')
                      ->orWhere('v_numbers.type', 'like', '%' . $this->search_text . '%');
                });
            })
            ->groupBy(
                'v_numbers.vnumber',
                'v_numbers.API_Token',
                'v_numbers.API_InstanceID',
                'v_numbers.API_Url'
            )
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage);
    }

    // Renders the Livewire view with the virtual numbers and headers
    public function render()
    {
        $vNumbers = $this->query(new VNumbers);
        return view('livewire.vnumber', [
            'vNumbers' => $vNumbers,
            'headers' => $this->headers,
        ]);
    }
}
