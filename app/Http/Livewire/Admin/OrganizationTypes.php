<?php

namespace App\Http\Livewire\Admin;

use App\Models\OrganizationType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;

class OrganizationTypes extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap";

    public $state = [];

    public $orgType;

    public $showEditModal = false;

    public $orgTypeIdBeingRemoved = null;

    public function createOrgType()
    {
        // dd($this->state);
        $validatedData = Validator::make($this->state, [
            'type' => 'required',
        ])->validate();

        OrganizationType::create($this->state);

        // session()->flash('message', 'User added successfully!');

        $this->dispatchBrowserEvent('hide-orgType-modal', ['message' => 'Organization added successfully!']);
    }

    public function addOrgType()
    {
        $this->reset();
        $this->state = [];
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-orgType-modal');
    }

    public function editdmin(OrganizationType $orgType)
    {
        $this->reset();
        $this->showEditModal = true;
        $this->orgType = $orgType;
        $this->state = $orgType->toArray();

        $this->dispatchBrowserEvent('show-orgType-modal');
        //dd($admin);
    }

    public function updateOrgType()
    {
        //dd($this->state);
        $validatedData = Validator::make($this->state, [
            'type' => 'required',
        ])->validate();

        $this->orgType->update($validatedData);

        // session()->flash('message', 'User added successfully!');

        $this->dispatchBrowserEvent('hide-orgType-modal', ['message' => 'orgType updated successfully!']);
    }

    public function confirmOrgTypeRemoval($orgTypeId)
    {
        $this->orgTypeIdBeingRemoved = $orgTypeId;
        $this->dispatchBrowserEvent('show-delete-modal');
    }

    public function deleteOrgType()
    {
        $orgType = OrganizationType::findOrFail($this->orgTypeIdBeingRemoved);

        $orgType->delete();

        $this->dispatchBrowserEvent('hide-delete-modal', ['message' => 'orgType deleted successfully!']);
    }

    public function render()
    {
        $orgTypes = OrganizationType::paginate(15);
        //dd($admins);
        return view('livewire.admin.organization-types', ['orgTypes' => $orgTypes]);
    }
}
