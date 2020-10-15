<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Dashboard;
use Redbastie\Swift\Components\SwiftComponent as S;
use Redbastie\Swift\Livewire\SwiftComponent;

class Index extends SwiftComponent
{
    public $routeUri = '/dashboard';
    public $routeName = 'dashboard';
    public $routeMiddleware = 'auth';
    public $pageTitle = 'Dashboard';
    protected $listeners = ['$refresh'];

    public function query()
    {
        $query = Dashboard::query();

        if (!empty($this->model['search'])) {
            $query->where('name', 'like', '%' . $this->model['search'] . '%');
            $query->orWhere('universe', 'like', '%' . $this->model['search'] . '%');
        }

        return $query->orderBy('name');
    }

    public function view()
    {
        $vehicles = $this->query()->paginate();

        return S::div(
            S::livewire('layouts.navbar'),

            S::container(
                S::heading($this->pageTitle),

                S::row(
                    S::col(S::input('search')->type('search')->placeholder('Search')->modelDebounce())->mdAuto()->mb(3),
                    S::col(S::button('Create Hero')->primary()->click('$emit', 'showCreateModal'))->mdAuto()->mb(3)
                )->justifyContentBetween(),

                S::listGroup(
                    S::each($vehicles, function ($vehicle) {
                        return S::listGroupItem(
                            S::row(
                                S::col(e($vehicle->name))->md(),
                                S::col(e($vehicle->universe))->md(),
                                S::col(
                                    S::button(S::icon('eye'))->title('Read')->link()->p(1)->click('$emit', 'showReadModal', $vehicle->id),
                                    S::button(S::icon('edit'))->title('Update')->link()->p(1)->click('$emit', 'showUpdateModal', $vehicle->id),
                                    S::button(S::icon('trash-alt'))->title('Delete')->link()->p(1)->click('delete', $vehicle->id)->confirm(),
                                )->mdAuto()
                            )->alignItemsCenter()
                        )->action();
                    })->empty(
                        S::listGroupItem('No one Hero is here.')
                    )
                )->mb(3),

                S::pagination($vehicles)
            )->py(4),

            S::livewire('dashboard.create'),
            S::livewire('dashboard.read'),
            S::livewire('dashboard.update')
        );
    }

    public function delete(Dashboard $dashboard)
    {
        $dashboard->delete();
        $this->emit('toastSuccess', 'Hero fired!');
    }
}
