<?php

namespace App\Http\Livewire\Admin;

use App\Models\TreatmentSupporter;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TreatmentSupporters extends Component
{
    public $orgId;

    public function mount($id)
    {
        $this->orgId = $id;
    }

    public function render()
    {
        $org = DB::table('organizations')->select('name')->find($this->orgId);
        $supporters = TreatmentSupporter::where('organization_id', $this->orgId)->latest()->paginate(5);
        return view('livewire.admin.treatment-supporters', ['supporters' => $supporters, 'org' => $org]);
    }
}
