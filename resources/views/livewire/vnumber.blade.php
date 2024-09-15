<div>
    <x-card title="List of Virtual Numbers" shadow>
        <!-- Grid with two columns for two buttons per row -->
        <div class="grid sm:grid-cols-8 gap-4">
            <x-button label="Redistribute CN/SN" link="/docs/installation" class="btn-primary text-white w-full" />
            <x-button label="Check Redistribution CN/SN" link="/docs/installation" class="btn-warning text-white w-full" />
            <x-button label="Instances Expiry Date" link="/docs/installation" class="btn-error text-white w-full" />
            <x-button label="List Down Instances" link="/docs/installation" class="btn-info text-white w-full" />
            <x-button label="Maintenance" link="/docs/installation" class="btn-primary text-white w-full" />
            <x-button label="Remove Parent/Teacher" link="/docs/installation" class="btn-error text-white w-full" />
            <x-button label="Create New API Instance" link="/docs/installation" class="btn-success text-white w-full" />
            <x-button label="Create New" link="/docs/installation" class="btn-success text-white w-full" />
        </div>

        <div class="mt-4">
            <!-- Search Input with debounce applied -->
            <x-input label="Search" placeholder="Search Virtual Numbers" wire:input.live.debounce.150ms="search" />
        </div>

        <!-- Virtual Numbers Table with pagination -->
        <x-table :headers="$headers" :rows="$vNumbers" :sort-by="$sortBy"
            :per-page-values="$perPageValues" per-page="perPage"
            with-pagination show-empty-text class="table-auto mt-4 w-full text-left border border-gray-300">
            @scope('actions', $vnumber)
            <div class="flex space-x-3">
                <x-button icon="o-eye" link="{{ route('vnumbers.view',['vnumber' => $vnumber->vnumber]) }}" spinner class="btn-sm btn-circle btn-outline" tooltip="View" no-wire-navigate />
                <x-button icon="o-trash" wire:confirm="Are you sure?" wire:click="delete({{ $vnumber->vnumber  }})" class="btn-sm btn-circle btn-error" tooltip="Delete" />
            </div>
            @endscope
        </x-table>
    </x-card>
</div>