<div class="space-y-4">
    <!-- Page header -->
    <div class="pb-2 flex items-center justify-between border-b">
        <x-typography.h3 class="font-semibold">
            Equipos de computo
        </x-typography.h3>
        <x-buttons.primary wire:click="$dispatch('openModal', { component: 'partials.modals.assets.CreateComputer' })">Agregar</x-buttons.primary>
    </div>
    <div>
        <livewire:partials.tables.assets.computers/>
    </div>
</div>