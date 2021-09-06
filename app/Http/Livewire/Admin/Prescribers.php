<?php

namespace App\Http\Livewire\Admin;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Prescribers extends Component
{
    public $orgId;

    public function mount($id)
    {
        $this->orgId = $id;
    }

    public function render()
    {
        $org = DB::table('organizations')->select('name')->find($this->orgId);
        $prescribers = DB::table('prescribers')
            ->leftJoin('prescriber_types', 'prescriber_types.id', '=', 'prescribers.prescriber_type')
            ->select('prescribers.*', 'prescriber_types.initial', 'prescriber_types.title')
            ->where('prescribers.organization_id', $this->orgId)
            ->latest()->paginate(5);
        return view('livewire.admin.prescribers', ['prescribers' =>$prescribers, 'org' => $org]);
    }
}
