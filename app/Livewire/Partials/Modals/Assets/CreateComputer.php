<?php

namespace App\Livewire\Partials\Modals\Assets;

use App\Models\Asset;
use App\Models\Assets\Event;
use App\Models\Catalogs\AssetType;
use App\Models\Catalogs\Manufacturer;
use App\Models\Catalogs\Subtype;
use App\Models\Organization\Location;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toaster;

class CreateComputer extends ModalComponent
{
    public static function modalMaxWidth(): string {
        return '2xl';
    }

    public static function closeModalOnEscape(): bool {
        return false;
    }

    public static function closeModalOnClickAway(): bool {
        return false;
    }

    public $manufacturers, $subtypes, $locations;

    //Properties
    public $manufacturer = '', $model, $serial, $subtype = '', $location = '', $remarks;

    public function mount(){
        $this->manufacturers = Manufacturer::orderBy('name', 'asc')->get();
        $this->subtypes = Subtype::where('type_id', 1)->orderBy('name', 'asc')->get();
        $this->locations = Location::whereIn('type', ['A', 'B'])->orderBy('name', 'asc')->get();
    }

    public function save(){
        
        //Fase 1 - Valida que no exista un equipo con el mismo numero de serie, si existe se detiene el proceso, si no existe inserta el registro.
        if(Asset::where('serial', strtoupper($this->serial))->exists()){
            Toaster::error('Ya existe un registro con el mismo numero de serie.'); 
        } else {
            DB::beginTransaction();
            try{
                $computer = Asset::create([
                    'category_id' => 1,
                    'type_id' => 1,
                    'subtype_id' => $this->subtype,
                    'asset_tag' => 'X',
                    'manufacturer_id' => $this->manufacturer,
                    'model' => $this->model,
                    'serial' => $this->serial,
                    'status_id' => 1,
                    'employee_id' => 1,
                    'location_id' => $this->location,
                    'require_maintenance' => AssetType::where('id', 1)->value('require_maitenance'),
                    'frequency_id' => AssetType::where('id', 1)->value('frequency_id'),
                    'last_maintenance' => date('Y-m-d'),
                    'carry_authorization' => 0,
                    'remarks' => $this->remarks,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id
                ]);

                //Fase 2 - Despues de insertar el registro, se genera el asset_tag y se actualiza el registro insertado.
                Asset::where('id', $computer->id)->update(['asset_tag' => generateAssetTag($computer->id)]);

                //Fase 3 - Inserta un registro de alta de inventario en la tabla de eventos.
                $ai = Event::create([
                    'event_tag' => 'X',
                    'event_type_id' => 1,
                    'start_date' => date('Y-m-d'),
                    'end_date' => date('Y-m-d'),
                    'asset_id' => $computer->id,
                    'status' => 0,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,                    
                ]);
                
                Event::where('id', $ai->id)->update(['event_tag' => 'AE-' . $ai->id]);
                
                //Fase 4 - Inserta un registro de asignacion de activo al usuario generico.
                $aa = Event::create([
                    'event_tag' => 'X',
                    'event_type_id' => 2,
                    'start_date' => date('Y-m-d'),
                    'asset_id' => $computer->id,
                    'employee_id' => 1,
                    'status' => 1,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,                    
                ]);
                
                Event::where('id', $aa->id)->update(['event_tag' => 'AE-' . $aa->id]);

                DB::commit();
    
                $this->dispatch('pg:eventRefresh-computers-table');
                $this->closeModal();
                Toaster::success('Registro insertado correctamente!'); 
            } catch(\Throwable $e){
                DB::rollBack();
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
                    <x-typography.h5>Agregar equipo de computo</x-typogrphy.h5>
                </div>
                <div class="p-4 overflow-y-auto">
                    <form wire:submit="save">
                        <div class="grid gap-4 mb-4 sm:grid-cols-3">
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
                            <div class="sm:col-span-2">
                                <x-forms.label>Modelo</x-forms.label>
                                <x-forms.input type="text" wire:model="model" maxlength="50" required/>
                            </div>
                            <div>
                                <x-forms.label>Numero de Serie</x-forms.label>
                                <x-forms.input type="text" class="uppercase" wire:model="serial" maxlength="50" required/>
                            </div>
                            <div>
                                <x-forms.label>Tipo</x-forms.label>
                                <x-forms.select wire:model="subtype" required>
                                    <option value="" disabled>Seleccione...</option>
                                        @foreach($subtypes as $subtype)
                                        <option value="{{$subtype->id}}">
                                            {{$subtype->name}}
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
