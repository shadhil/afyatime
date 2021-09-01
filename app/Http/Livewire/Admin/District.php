<?php

namespace App\Http\Livewire\Admin;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class District extends Component
{
    public $regionId;

    public function mount($id)
    {
        $this->regionId = $id;
    }

    public function render()
    {
        $region = DB::table('regions')->find($this->regionId);

        $districts = DB::table('districts')
            ->select('id', 'name')
            ->where('region_id', $this->regionId)
            ->get();
        return view('livewire.admin.district', ['districts' => $districts, 'region' => $region]);
    }
}
