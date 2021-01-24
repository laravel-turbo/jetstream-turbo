<x-jet-action-section>
    <x-slot name="title">
        {{ __('Delete :Team', ['Team' => ucfirst(LaravelTurbo\JetstreamTurbo\JetstreamTurbo::teamAlias())]) }}
    </x-slot>

    <x-slot name="description">
        {{ __('Permanently delete this :Team.', ['Team' => LaravelTurbo\JetstreamTurbo\JetstreamTurbo::teamAlias()]) }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600">
            {{ __('Once a :Team is deleted, all of its resources and data will be permanently deleted. Before deleting this :Team, please download any data or information regarding this team that you wish to retain.', ['Team' => LaravelTurbo\JetstreamTurbo\JetstreamTurbo::teamAlias()]) }}
        </div>

        <div class="mt-5">
            <x-jet-danger-button wire:click="$toggle('confirmingTeamDeletion')" wire:loading.attr="disabled">
                {{ __('Delete :Team', ['Team' => ucfirst(LaravelTurbo\JetstreamTurbo\JetstreamTurbo::teamAlias())]) }}
            </x-jet-danger-button>
        </div>

        <!-- Delete Team Confirmation Modal -->
        <x-jet-confirmation-modal wire:model="confirmingTeamDeletion">
            <x-slot name="title">
                {{ __('Delete :Team', ['Team' => ucfirst(LaravelTurbo\JetstreamTurbo\JetstreamTurbo::teamAlias())]) }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to delete this :Team? Once a :Team is deleted, all of its resources and data will be permanently deleted.', ['Team' => LaravelTurbo\JetstreamTurbo\JetstreamTurbo::teamAlias()]) }}
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmingTeamDeletion')" wire:loading.attr="disabled">
                    {{ __('Nevermind') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="deleteTeam" wire:loading.attr="disabled">
                    {{ __('Delete :Team', ['Team' => ucfirst(LaravelTurbo\JetstreamTurbo\JetstreamTurbo::teamAlias())]) }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-confirmation-modal>
    </x-slot>
</x-jet-action-section>
