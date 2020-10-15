<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Dashboard;
use Redbastie\Swift\Components\SwiftComponent as S;
use Redbastie\Swift\Livewire\SwiftComponent;

class Update extends SwiftComponent
{
    public $vehicle;
    protected $listeners = ['showUpdateModal'];

    public function view()
    {
        return S::form(
            S::modal('update-modal')->fade()->heading('Update your Hero')
                ->body(
                    S::input('name')->label('Name')->modelDefer(),
                    S::input('universe')->label('Universe')->modelDefer(),
                    S::select('color')->options(['Red','Green','Black','Yellow','White','Red'])->label('Color of Hero')->modelDefer(),
                    S::select('superpower')->options(['yes','no'])->label('Has superpower')->modelDefer(),
                )
                ->footer(
                    S::button('Cancel')->secondary()->click('$emit', 'hideModal', 'update-modal'),
                    S::button('Save')->submit()->primary()
                )
        )->submitPrevent('save');
    }

    public function showUpdateModal(Dashboard $dashboard)
    {
        $this->dashboard = $dashboard;
        $this->model = $dashboard->toArray();
        $this->emit('showModal', 'update-modal');
    }

    public function save()
    {
        $validatedData = $this->validate([
            'name' => ['required'],
            'universe' => ['required'],
            'color' => ['required'],
            'superpower' => ['required'],
        ]);

        $this->vehicle->update($validatedData);

        $this->emit('hideModal', 'update-modal');
        $this->emit('toastSuccess', 'Dashboard updated!');
        $this->emitUp('$refresh');
    }
}
