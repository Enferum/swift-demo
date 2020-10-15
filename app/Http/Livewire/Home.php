<?php

namespace App\Http\Livewire;

use App\Models\Dashboard;
use Redbastie\Swift\Components\SwiftComponent as S;
use Redbastie\Swift\Livewire\SwiftComponent;

class Home extends SwiftComponent
{
    public $routeUri = '/home';
    public $routeName = 'home';
    public $routeMiddleware = 'auth';
    public $pageTitle = 'Congratulation!';

    public function view()
    {
        $vehicles = (new Dashboard)->query()->paginate();

        return S::div(
            S::livewire('layouts.navbar'),

            S::container(
                S::row(
                    S::col(S::card()->header($this->pageTitle)->body('You are logged in and it\' time to create your Hero!'))->md(5)
                )
                    ->justifyContentCenter())->py(4),

            S::row(
                S::col(S::card()->header('All heroes created know')->body(
                    S::each($vehicles, function ($vehicle) {
                        return S::listGroupItem(
                            S::row(
                                S::col(e($vehicle->name))->md(),
                                S::col(e($vehicle->universe))->md()
                                    ->mdAuto(),
                            )->alignItemsCenter()
                        )->action();
                    }))
                    ->footer(S::row(S::button('Make your Hero')->info()->click('$emit', 'showCreateModal'))->justifyContentCenter())
                )->md(4)
            )->justifyContentCenter()
        );
    }
}
