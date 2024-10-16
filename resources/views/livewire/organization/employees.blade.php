<div class="space-y-4">
    <!-- Page header -->
    <div class="pb-2 flex items-center justify-between border-b">
        <x-typography.h3 class="font-semibold">
            Colaboradores
        </x-typography.h3>
        <x-buttons.primary wire:click="$dispatch('openModal', { component: 'partials.modals.organization.CreateEmployee' })">Agregar</x-buttons.primary>
    </div>
    <div>
        <livewire:partials.tables.organization.employees-table/>
    </div>
</div>