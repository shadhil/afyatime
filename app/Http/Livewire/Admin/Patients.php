<?php

namespace App\Http\Livewire\Admin;

use App\Models\Patient;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Patients extends Component
{
    public $orgId;

    public function mount($id)
    {
        $this->orgId = $id;
    }

    public function render()
    {
        $org = DB::table('organizations')->select('name')->find($this->orgId);
        $patients = Patient::where('organization_id', $this->orgId)
            ->latest()
            ->paginate(5);
        return view('livewire.admin.patients', ['patients' =>$patients, 'org' => $org]);
    }
}
