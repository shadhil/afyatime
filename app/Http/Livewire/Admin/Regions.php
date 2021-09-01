<?php

namespace App\Http\Livewire\Admin;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Regions extends Component
{
    public function render()
    {
        $regions = DB::table('regions')
            ->select('id', 'name')
            ->get();
        return view('livewire.admin.regions', ['regions' => $regions]);
    }
}
