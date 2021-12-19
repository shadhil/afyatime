<?php

namespace App\Http\Livewire\Admin;

use App\Models\TreatmentSupporter;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class TreatmentSupporters extends Component
{
    use WithPagination;

    public $orgId;
    public $orgName;
    public $searchTerm;

    public function mount($id)
    {
        $this->orgId = $id;

        $org = DB::table('organizations')->select('name')->where('id', $id)->first();
        $this->orgName = $org->name;
    }

    public function updatedsearchTerm()
    {
        $this->resetPage();
    }

    public function searchPatient()
    {
        $this->resetPage();
        // dd($this->searchTerm);
    }

    public function render()
    {

        if ($this->searchTerm != null) {
            $supporters = TreatmentSupporter::query()
                ->where('organization_id', $this->orgId)
                ->where('full_name', 'like', '%' . $this->searchTerm . '%')
                ->latest()->paginate(4);
        } else {
            $supporters = TreatmentSupporter::query()
                ->where('organization_id', $this->orgId)
                ->latest()->paginate(4);
        }
        return view('livewire.admin.treatment-supporters', ['supporters' => $supporters])->layout('layouts.admin-base');
    }
}
