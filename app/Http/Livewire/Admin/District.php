<?php

namespace App\Http\Livewire\Admin;

use App\Models\District as ModelsDistrict;
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

        $districts = ModelsDistrict::query()
            ->where('region_id', $this->regionId)
            ->get();

        return view('livewire.admin.district', ['districts' => $districts, 'region' => $region])->layout('layouts.admin-base');
    }
}
