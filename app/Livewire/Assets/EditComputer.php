<?php

namespace App\Livewire\Assets;

use App\Models\Asset;
use App\Models\Catalogs\Manufacturer;
use App\Models\Catalogs\Subtype;
use App\Models\Organization\Location;
use Livewire\Attributes\Title;
use Livewire\Component;

class EditComputer extends Component
{
    //Catalogs
    public $asset_data, $manufacturers;

    //Properties
    public $asset_tag, $manufacturer, $model, $serial;

    public function mount($id){
        $this->asset_data = Asset::where('id', $id)->first();
        $this->manufacturers = Manufacturer::orderBy('name', 'asc')->get();

        $this->asset_tag = $this->asset_data->asset_tag;
        $this->manufacturer = $this->asset_data->manufacturer_id;
        $this->model = $this->asset_data->model;
        $this->serial = $this->asset_data->serial;
    }

    #[Title('Editar equipo de computo')] 
    public function render()
    {
        return view('livewire.assets.edit-computer');
    }
}
