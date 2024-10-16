<?php

namespace App\Livewire\Organization;

use Livewire\Attributes\Title;
use Livewire\Component;

class Departments extends Component
{
    #[Title('Departamentos')] 
    public function render()
    {
        return view('livewire.organization.departments');
    }
}
