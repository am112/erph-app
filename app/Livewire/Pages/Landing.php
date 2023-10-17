<?php

namespace App\Livewire\Pages;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Landing extends Component
{
    #[Layout('components.layouts.auth')]
    #[Title('Home')]  
    public function render()
    {
        return view('pages.index');
    }
}
