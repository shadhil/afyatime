<?php


namespace App\Http\Livewire\Admin;

use App\Models\PrescriberType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;

class PrescriberTypes extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap";

    public $state = [];

    public $prescriberType;

    public $showEditModal = false;

    public $prescriberTypeIdBeingRemoved = null;

    public function createPrescriberType()
    {
        // dd($this->state);
        $validatedData = Validator::make($this->state, [
            'title' => 'required',
        ])->validate();

        PrescriberType::create($this->state);

        // session()->flash('message', 'User added successfully!');

        $this->dispatchBrowserEvent('hide-prescriberType-modal', ['message' => 'Organization added successfully!']);
    }

    public function addPrescriberType()
    {
        $this->reset();
        $this->state = [];
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-prescriberType-modal');
    }

    public function editPrsecriberType(PrescriberType $prescriberType)
    {
        $this->reset();
        $this->showEditModal = true;
        $this->prescriberType = $prescriberType;
        $this->state = $prescriberType->toArray();

        $this->dispatchBrowserEvent('show-prescriberType-modal');
        //dd($admin);
    }

    public function updatePrescriberType()
    {
        //dd($this->state);
        $validatedData = Validator::make($this->state, [
            'title' => 'required',
            'initial' => 'sometimes',
        ])->validate();

        $this->prescriberType->update($validatedData);

        // session()->flash('message', 'User added successfully!');

        $this->dispatchBrowserEvent('hide-prescriberType-modal', ['message' => 'prescriberType updated successfully!']);
    }

    public function confirmPrescriberTypeRemoval($prescriberTypeId)
    {
        $this->prescriberTypeIdBeingRemoved = $prescriberTypeId;
        $this->dispatchBrowserEvent('show-delete-modal');
    }

    public function deletePrescriberType()
    {
        $prescriberType = PrescriberType::findOrFail($this->prescriberTypeIdBeingRemoved);

        $prescriberType->delete();

        $this->dispatchBrowserEvent('hide-delete-modal', ['message' => 'prescriberType deleted successfully!']);
    }

    public function render()
    {
        $prescriberTypes = PrescriberType::paginate(15);
        //dd($admins);
        return view('livewire.admin.prescriber-types', ['prescriberTypes' => $prescriberTypes])->layout('layouts.admin-base');
    }
}
