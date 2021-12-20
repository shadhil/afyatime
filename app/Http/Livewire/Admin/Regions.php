<?php

namespace App\Http\Livewire\Admin;

use App\Models\Region;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Regions extends Component
{
    public function render()
    {
        $regions = Region::all();
        return view('livewire.admin.regions', ['regions' => $regions])->layout('layouts.admin-base');
    }
}
