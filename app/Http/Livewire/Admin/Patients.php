<?php

namespace App\Http\Livewire\Admin;

use App\Models\Patient;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Patients extends Component
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
        // $org = DB::table('organizations')->select('name')->find($this->orgId);
        if ($this->searchTerm != null) {
            $patients = Patient::where('organization_id', $this->orgId)
                ->where(function ($query) {
                    $query->where('first_name', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('patient_code', 'like', '%' . $this->searchTerm . '%');
                })
                ->latest()->paginate(4);
        } else {
            $patients = Patient::where('organization_id', $this->orgId)
                ->latest()->paginate(12);
        }
        return view('livewire.admin.patients', ['patients' => $patients])->layout('layouts.admin-base');
    }
}
