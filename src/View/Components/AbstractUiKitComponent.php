<?php

namespace ChrisKelemba\LaravelUiKit\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

abstract class AbstractUiKitComponent extends Component
{
    protected string $view;

    public function render(): View
    {
        return view($this->view);
    }
}