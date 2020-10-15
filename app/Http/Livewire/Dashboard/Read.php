<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Dashboard;
use Illuminate\Support\Str;
use Redbastie\Swift\Components\SwiftComponent as S;
use Redbastie\Swift\Livewire\SwiftComponent;

class Read extends SwiftComponent
{
    public $hero;
    protected $listeners = ['showReadModal'];

    public function view()
    {
        return S::modal('read-modal')->fade()->heading('Hero')
            ->body(
                S::each($this->hero ? $this->hero->toArray() : [], function ($value, $key) {
                    return S::div(
                        S::label(Str::title(str_replace('_', ' ', Str::snake($key))))->textMuted(),

                        is_array($value) ?
                            S::pre(json_encode($value, JSON_PRETTY_PRINT)) :
                            S::paragraph($value ?? 'N/A')
                    );
                })
            )
            ->footer(
                S::button('Close')->secondary()->click('$emit', 'hideModal', 'read-modal')
            );
    }

    public function showReadModal(Dashboard $dashboard)
    {
        $this->hero = $dashboard;
        $this->emit('showModal', 'read-modal');
    }
}
