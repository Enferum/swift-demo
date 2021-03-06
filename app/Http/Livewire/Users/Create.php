<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Redbastie\Swift\Components\SwiftComponent as S;
use Redbastie\Swift\Livewire\SwiftComponent;

class Create extends SwiftComponent
{
    protected $listeners = ['showCreateModal'];

    public function view()
    {
        return S::form(
            S::modal('create-modal')->fade()->heading('Create User')
                ->body(
                    S::input('name')->label('Name')->modelDefer(),
                    S::input('email')->type('email')->label('Email')->modelDefer(),
                    S::input('password')->type('password')->label('Password')->modelDefer(),
                    S::input('password_confirmation')->type('password')->label('Confirm Password')->modelDefer(),
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
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed'],
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);

        User::query()->create($validatedData);

        $this->emit('hideModal', 'create-modal');
        $this->emit('toastSuccess', 'User created!');
        $this->emitUp('$refresh');
    }
}
