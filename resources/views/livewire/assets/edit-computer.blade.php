<div class="space-y-4">
    <!-- Page header -->
    <div class="pb-2 flex items-center justify-between border-b">
        <x-typography.h3 class="font-semibold">
            <a href="{{ route('computers') }}" wire:navigate><i
                    class="fa-solid fa-circle-chevron-left font-normal mr-1 text-primary-800"></i></a>
            Editar equipo de computo 
        </x-typography.h3>
        <div class="space-y-2">
            <div class="hs-dropdown relative inline-flex">
                <x-buttons.primary id="hs-dropdown-default" type="button" class="hs-dropdown-toggle" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                    Acciones
                    <i class="fa-solid fa-chevron-down hs-dropdown-open:rotate-180 size-3"></i>
                </x-buttons.primary>


                <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-60 bg-white shadow-md rounded-lg mt-2 dark:bg-neutral-800 dark:border dark:border-neutral-700 dark:divide-neutral-700 after:h-4 after:absolute after:-bottom-4 after:start-0 after:w-full before:h-4 before:absolute before:-top-4 before:start-0 before:w-full"
                    role="menu" aria-orientation="vertical" aria-labelledby="hs-dropdown-default">
                    <div class="p-1 space-y-0.5">
                        <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700"
                            href="#" wire:click="$dispatch('openModal', { component: 'partials.modals.assets.allocate', arguments: { asset: {{ $asset_data->id }} }})">
                            <i class="fa-solid fa-user-check"></i>
                            Asignar activo
                        </a>
                        <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700"
                        href="#" wire:click="$dispatch('openModal', { component: 'partials.modals.maintenances.register', arguments: { asset: {{ $asset_data->id }} }})">
                            <i class="fa-solid fa-screwdriver-wrench"></i>
                            Registrar mantenimiento
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <form>
            <div class="grid sm:grid-cols-6 gap-4 mb-4">
                <div>
                    <x-forms.label>ID</x-forms.label>
                    <x-forms.input type="text" class="uppercase" wire:model="asset_tag" maxlength="9" required readonly/>
                </div>
                <div>
                    <x-forms.label>Marca</x-forms.label>
                    <x-forms.select wire:model="manufacturer" required>
                        <option value="" disabled>Seleccione...</option>
                            @foreach($manufacturers as $manufacturer)
                            <option value="{{$manufacturer->id}}">
                                {{$manufacturer->name}}
                            </option>
                        @endforeach
                    </x-forms.select>
                </div>
                <div class="md:col-span-2">
                    <x-forms.label>Modelo</x-forms.label>
                    <x-forms.input type="text" wire:model="model" maxlength="50" required/>
                </div>
                <div>
                    <x-forms.label>Serie</x-forms.label>
                    <x-forms.input type="text" class="uppercase" wire:model="serial" maxlength="25" required/>
                </div>
            </div>
        </form>
    </div>
</div>
