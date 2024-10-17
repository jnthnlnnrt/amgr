<?php

namespace App\Livewire\Assets;

use Livewire\Attributes\Title;
use Livewire\Component;

class Computers extends Component
{
    #[Title('Equipos de computo')] 
    public function render()
    {
        return view('livewire.assets.computers');
    }
}
