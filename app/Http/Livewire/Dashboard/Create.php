<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Dashboard;
use Redbastie\Swift\Components\SwiftComponent as S;
use Redbastie\Swift\Livewire\SwiftComponent;

class Create extends SwiftComponent
{
    protected $listeners = ['showCreateModal'];

    public function view()
    {
        return S::form(
            S::modal('create-modal')->fade()->heading('Create your Hero')
                ->body(
                    S::input('name')->label('Name')->modelDefer(),
                    S::select('universe')->options(['DC','Marvel'])->label('Universe')->modelDefer(),
                    S::select('color')->options(['Red','Green','Black','Yellow','White','Red'])->label('Color of Hero')->modelDefer(),
                    S::select('superpower')->options(['yes','no'])->label('Has superpower')->modelDefer(),
                )
                ->footer(
                    S::button('Cancel')->secondary()->click('$emit', 'hideModal', 'create-modal'),
                    S::button('Save')->submit()->primary()
                )
        )->submitPrevent('save');
    }

    public function showCreateModal()
    {
        $this->reset('model');
        $this->emit('showModal', 'create-modal');
    }

    public function save()
    {
        $validatedData = $this->validate([
            'name' => ['required'],
            'universe' => ['required'],
            'color' => ['required'],
            'superpower' => ['required'],
        ]);

        Dashboard::query()->create($validatedData);

        $this->emit('hideModal', 'create-modal');
        $this->emit('toastSuccess', 'Hero is created!');
        $this->emitUp('$refresh');
    }
}
