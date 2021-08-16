<?php

namespace App\Http\Livewire;

use App\Models\Prescriber;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Prescribers extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = "bootstrap";

    public $state = [];
    public $editState = [];

    public $showEditModal = false;

    public $prescriberId = null;

    public $searchTerm = null;

    public $photo;


    public function createPrescriber()
    {
        // dd($this->state);
        Validator::make($this->state, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'prescriber_type' => 'required',
            'password' => 'required|confirmed',
        ])->validate();
        //$this->state['password'] = bcrypt($this->state['password']);
        //$this->state['admin_type'] = 'admin';

        if ($this->profile_photo) {
            $this->state['profile_photo'] = $this->photo->store('/', 'profiles');
        } else {
            $this->state['profile_photo'] = NULL;
        }

        DB::transaction(function () {

            $newPrescriber = Prescriber::create($this->state);

            $newUser = User::create([
                'name' => $this->state['first_name'] . ' ' . $this->state['last_name'],
                'email' => $this->state['email'],
                'profile_photo' => $this->state['profile_photo'],
                'password' => Hash::make($this->state['password']),
                'account_type' => 'prescriber',
                'account_id' => $newPrescriber->id,
                'org_id' => Auth::user()->org_id,
            ]);

            if ($newUser) {
                $this->dispatchBrowserEvent('hide-org-modal', ['message' => 'Organization added successfully!']);
            }
        });
    }



    public function searchPrescriber()
    {
        dd($this->searchTerm);
    }

    public function render()
    {
        $prescribers = Prescriber::latest()->paginate(5);
        $prescriberTypes = DB::table('prescriber_types')
            ->select('id', 'title')
            ->get();
        return view('livewire.prescribers', ['prescribers' => $prescribers, 'prescriberTypes' => $prescriberTypes]);
    }
}
