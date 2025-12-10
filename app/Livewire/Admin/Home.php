<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Home extends Component
{
    protected $layout = 'components.layouts.app';

    public function render()
    {
        return view('livewire.admin.home')
            ->with(['title' => 'Admin Dashboard']);
    }
}
