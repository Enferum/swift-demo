<?php

namespace App\Http\Livewire\Layouts;

use Illuminate\Support\Facades\Route;
use Redbastie\Swift\Components\SwiftComponent as S;
use Redbastie\Swift\Livewire\SwiftComponent;

class Navbar extends SwiftComponent
{
    protected $listeners = ['$refresh'];

    public function view()
    {
        return S::div(
            S::navbar(S::container(
                S::navbarBrand(S::livewire('layouts.logo'))->href(route('welcome')),
                S::navbarToggler(),

                S::if(auth()->check(), function () {
                    return S::navbarCollapse(
                        S::navbarNav(
                            S::navItem(S::navLink('Dashboard')->href(route('dashboard'))),
                            S::navItem(S::navLink('Home')->href(route('home'))),
                            S::navItem(S::navLink('Users')->href(route('users'))),
                            // crud command hook
                        )->mrAuto(),
                        S::navbarNav(
                            S::navDropdown()
                                ->toggle(S::navLink(S::icon('user-circle'), auth()->user()->name)->dropdownToggle())
                                ->items(
                                    S::button('Profile')->dropdownItem()->click('$emit', 'showModal', 'profile-modal'),
                                    S::livewire('auth.logout')
                                )
                                ->right()
                        )->mlAuto()
                    );
                })->else(function () {
                    return S::navbarCollapse(
                        S::navbarNav(
                            S::navItem(S::navLink('Login')->href(route('login'))),
                            S::if(Route::has('register'), function () {
                                return S::navItem(S::navLink('Register')->href(route('register')));
                            })
                        )->mlAuto()
                    );
                })
            ))->expandMd()->light(),

            S::if(auth()->check(), function () {
                return S::livewire('auth.profile');
            })
        );
    }
}
