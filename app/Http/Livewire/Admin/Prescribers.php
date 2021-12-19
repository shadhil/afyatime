<?php

namespace App\Http\Livewire\Admin;

use App\Models\Prescriber;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Prescribers extends Component
{
    use WithPagination;

    public $orgId;
    public $orgName;

    public function mount($id)
    {
        $this->orgId = $id;

        $org = DB::table('organizations')->select('name')->where('id', $id)->first();
        $this->orgName = $org->name;
    }

    public function render()
    {
        $prescribers = Prescriber::query()
            ->where('prescribers.organization_id', $this->orgId)
            ->latest()->paginate(2);
        return view('livewire.admin.prescribers', ['prescribers' => $prescribers])->layout('layouts.admin-base');
    }
}
