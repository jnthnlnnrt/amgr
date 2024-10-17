<?php

namespace App\Livewire\Partials\Modals\Maintenances;

use App\Models\Catalogs\EventType;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class Register extends ModalComponent
{
    public static function modalMaxWidth(): string {
        return 'sm';
    }

    public static function closeModalOnEscape(): bool {
        return false;
    }

    public static function closeModalOnClickAway(): bool {
        return false;
    }

    public function cancel(){
        $this->closeModal();
    }

    //Catalogs
    public $maintenance_types;

    //Properties
    public $asset, $maintenance_type = '', $remarks;

    public function mount(){
        $this->maintenance_types = EventType::whereIn('id', ['3', '4'])->orderBy('name', 'asc')->get();
    }

    public function render()
    {
        return <<<'HTML'
        <div>
            <div class="flex flex-col bg-white border shadow-sm rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
                <div class="flex justify-between items-center py-3 px-4 border-b dark:border-neutral-700">
                    <x-typography.h5 class="font-semibold">Registrar mantenimiento</x-typogrphy.h5>
                </div>
                <div class="p-4 overflow-y-auto">
                    <form wire:submit="save">
                        <div class="grid sm:grid-cols-2 gap-4 mb-4">
                            <div class="sm:col-span-2"> 
                                <x-forms.label>Tipo de mantenimiento</x-forms.label>
                                <x-forms.select wire:model="maintenance_type" required>
                                    <option value="" disabled>Seleccione...</option>
                                    @foreach($maintenance_types as $mt)
                                        <option value="{{$mt->id}}">
                                            {{$mt->name}}
                                        </option>
                                    @endforeach
                                </x-forms.select>
                            </div>
                            <div class="sm:col-span-2">
                                <x-forms.label>Comentarios</x-forms.label>
                                <x-forms.textarea rows="4" wire:model="remarks"></x-forms.textarea>
                            </div>
                        </div>
                        <div class="flex items-center justify-end space-x-2">
                            <x-buttons.primary type="submit">Guardar</x-buttons.primary>
                            <x-buttons.danger type="button" wire:click="cancel">Cancelar</x-buttons.danger>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        HTML;
    }
}
