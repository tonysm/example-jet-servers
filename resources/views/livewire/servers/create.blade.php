<x-jet-form-section submit="createServer">
    <x-slot name="title">
        {{ __('Create Server') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Create a new server to host your sites here.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Server Name') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model="state.name" autofocus />
            <x-jet-input-error for="state.name" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Server Size') }}" />
            <x-select-input id="server_size" wire:model.defer="state.server_size" :options="$options" placeholder="Select a size" />
            <x-jet-input-error for="state.server_size" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-button>
            {{ __('Create') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
