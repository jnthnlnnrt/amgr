<?php

namespace App\Livewire\Partials\Modals\Assets;

use App\Models\Asset;
use App\Models\Assets\Event;
use App\Models\Organization\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toaster;

class Allocate extends ModalComponent
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

    //Catalogs
    public $employees;

    //Propiedades
    public $asset, $employee = '', $carry_authorization = '', $remarks;

    public function mount(){
        $this->employees = Employee::where('id', '!=', 1)->orderBy('name', 'asc')->get();
    }

    public function save(){
        try {
            DB::beginTransaction();
            //Buscamos y actualizamos la asignacion previa.
            Event::where('asset_id', $this->asset)
            ->where('event_type_id', 2)
            ->where('status', 1)
            ->update(['end_date' => date('Y-m-d'), 'status' => 0, 'updated_by' => Auth::user()->id]);

            //Creamos el registro de la nueva asignacion
            $aa = Event::create([
                'event_tag' => 'X',
                'event_type_id' => 2,
                'start_date' => date('Y-m-d'),
                'asset_id' => $this->asset,
                'employee_id' => $this->employee,
                'status' => 1,
                'remarks' => $this->remarks,
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id
            ]);

            Event::where('id', $aa->id)->update(['event_tag' => 'AE-' . $aa->id]);

            //Actualizamos el activo con la nueva asignacion y autorizacion de salida
            Asset::where('id', $this->asset)->update([
                'status_id' => 2,
                'employee_id' => $this->employee,
                'location_id' => Employee::where('id', $this->employee)->first()->location_id,
                'carry_authorization' => $this->carry_authorization,
                'updated_by' => Auth::user()->id,  
            ]);

            DB::commit();

            $this->closeModal();
            Toaster::success('Activo asignado correctamente!');
            $this->redirect('/assets/computers'); 
        } catch (\Throwable $e) {
            DB::rollBack();
            Toaster::error('Hubo un error al asignar el activo.' . $e->getMessage()); 
        } 
    }

    public function cancel(){
        $this->closeModal();
    }

    public function render()
    {
        return <<<'HTML'
        <div>
        <div class="flex flex-col bg-white border shadow-sm rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
                <div class="flex justify-between items-center py-3 px-4 border-b dark:border-neutral-700">
                    <x-typography.h5 class="font-semibold">Asignar equipo de computo</x-typogrphy.h5>
                </div>
                <div class="p-4 overflow-y-auto">
                    <form wire:submit="save">
                        <div class="grid sm:grid-cols-2 gap-4 mb-4">
                            <div class="sm:col-span-2">
                                <x-forms.label>Usuario</x-forms.label>
                                <x-forms.select wire:model="employee" required>
                                    <option value="" disabled>Seleccione...</option>
                                    @foreach($employees as $emp)
                                        <option value="{{$emp->id}}">
                                            {{$emp->name}}
                                        </option>
                                    @endforeach
                                </x-forms.select>
                            </div>
                            <div>
                                <x-forms.label>Autorizacion de salida:</x-forms.label>
                                <x-forms.select wire:model="carry_authorization" required>
                                    <option value="" disabled>Seleccione...</option>
                                    <option value="1">Si</option>
                                    <option value="0">No</option>
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
