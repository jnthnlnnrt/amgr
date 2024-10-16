<?php

namespace App\Livewire\Partials\Modals\Organization;

use App\Models\Organization\Department;
use App\Models\Organization\Employee;
use App\Models\Organization\Location;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toaster;

class CreateEmployee extends ModalComponent
{
    public static function modalMaxWidth(): string {
        return 'xl';
    }

    public static function closeModalOnEscape(): bool {
        return false;
    }

    public static function closeModalOnClickAway(): bool {
        return false;
    }

    public $departments, $locations;

    //Properties
    public $internal_id, $name, $email, $department = '', $location = '', $remarks;

    public function mount(){
        $this->departments = Department::orderBy('name', 'asc')->get();
        $this->locations = Location::whereIn('type', ['U','B'])->orderBy('name', 'asc')->get();
    }


    public function save(){
        if(Employee::where('internal_id', $this->internal_id)->exists()){
            Toaster::error('Ya existe un colaborador con el mismo numero de ID.');
        } else{
            try{
                Employee::create([
                    'internal_id' => $this->internal_id,
                    'name' => $this->name,
                    'email' => $this->email,
                    'department_id' => $this->department,
                    'location_id' => $this->location,
                    'status' => 1,
                    'remarks' => $this->remarks,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                ]);

                $this->dispatch('pg:eventRefresh-employees-table');
                $this->closeModal();
                Toaster::success('Registro insertado correctamente!'); 
            } catch(\Throwable $e){ 
                Toaster::error('Hubo un error al insertar el registro.' . $e->getMessage()); 
            }
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
                    <x-typography.h5>Agregar colaborador</x-typogrphy.h5>
                </div>
                <div class="p-4 overflow-y-auto">
                    <form wire:submit="save">
                        <div class="grid gap-4 mb-4 sm:grid-cols-3">
                            <div>
                                <x-forms.label>ID</x-forms.label>
                                <x-forms.input type="text" wire:model="internal_id" maxlength="6" required/>
                            </div>
                            <div class="md:col-span-2">
                                <x-forms.label>Nombre</x-forms.label>
                                <x-forms.input type="text" wire:model="name" required/>
                            </div>
                            <div class="md:col-span-2">
                                <x-forms.label>Correo electronico</x-forms.label>
                                <x-forms.input type="email" wire:model="email"/>
                            </div>
                            <div class="hidden md:block">

                            </div>
                            <div>
                                <x-forms.label>Departamento</x-forms.label>
                                <x-forms.select wire:model="department" required>
                                    <option value="" disabled>Seleccione...</option>
                                    @foreach($departments as $department)
                                        <option value="{{$department->id}}">
                                            {{$department->name}}
                                        </option>
                                    @endforeach
                                </x-forms.select>
                            </div>
                            <div>
                                <x-forms.label>Ubicacion</x-forms.label>
                                <x-forms.select wire:model="location" required>
                                    <option value="" disabled>Seleccione...</option>
                                    @foreach($locations as $location)
                                        <option value="{{$location->id}}">
                                            {{$location->name}}
                                        </option>
                                    @endforeach
                                </x-forms.select>
                            </div>
                            <div class="sm:col-span-3">
                                <x-forms.label>Comentarios</x-forms.label>
                                <x-forms.input type="text" wire:model="remarks" />
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
