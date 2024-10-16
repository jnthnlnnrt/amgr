<?php

namespace App\Livewire\Organization;

use Livewire\Attributes\Title;
use Livewire\Component;

class Employees extends Component
{
    #[Title('Colaboradores')] 
    public function render()
    {
        return view('livewire.organization.employees');
    }
}
