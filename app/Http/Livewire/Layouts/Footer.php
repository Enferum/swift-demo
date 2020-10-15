<?php

namespace App\Http\Livewire\Layouts;

use Illuminate\Support\Facades\Route;
use Redbastie\Swift\Components\SwiftComponent as S;
use Redbastie\Swift\Livewire\SwiftComponent;

class Footer extends SwiftComponent
{
    protected $listeners = ['$refresh'];

    public function view()
    {
        return S::div(
            S::form(111111)
        );
    }
}
