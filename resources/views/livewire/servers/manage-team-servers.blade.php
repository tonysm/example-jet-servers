<div>
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
                <x-jet-input id="name" type="text" class="mt-1 block w-full bg-cool-gray-100" wire:model.defer="state.name" autofocus :disabled="true" />
                <x-jet-button type="button" class="mt-2" wire:click="generateName">Generate Name</x-jet-button>
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
                {{ __('Create & Provision') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>

    @if ($servers->isNotEmpty())
        <x-jet-section-border />

        <!-- Manage Servers -->
        <div class="mt-10 sm:mt-0" wire:poll>
            <x-jet-action-section>
                <x-slot name="title">
                    {{ __('Team Servers') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('All of the servers that are part of this team.') }}
                </x-slot>

                <!-- Team Server List -->
                <x-slot name="content">
                    <div class="space-y-6">
                        @foreach ($servers->sortBy('name') as $server)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="ml-4">{{ $server->name }}</div>
                                    <div class="ml-2 text-xs text-cool-gray-400">{{ $server->server_size }}, {{ $server->status }}</div>
                                </div>

                                <div class="flex items-center">
                                    <!-- Remove Server -->
                                    <button class="cursor-pointer ml-6 text-sm text-red-500 focus:outline-none" wire:click="confirmDeleteServer('{{ $server->id }}')">
                                        {{ __('Remove') }}
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-slot>
            </x-jet-action-section>
        </div>

        <!-- Leave Team Confirmation Modal -->
        <x-jet-confirmation-modal wire:model="confirmingDeleteServer">
            <x-slot name="title">
                {{ __('Delete Server') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you would like to delete this server?') }}
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmingDeleteServer')" wire:loading.attr="disabled">
                    {{ __('Nevermind') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="deleteServer" wire:loading.attr="disabled">
                    {{ __('Delete') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-confirmation-modal>
    @endif
</div>
