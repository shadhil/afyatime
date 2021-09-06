<?php

namespace App\Http\Livewire;

use App\Mail\Gmail;
use App\Models\Prescriber;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
    public $userId = null;

    public $searchTerm = null;

    public $photo;
    public $profilePhoto;

    public function createPrescriber()
    {
        // $email = "shadhil90@gmail.com";
        // $details = [
        //     'title' => 'First Time for Everything',
        //     'body' => 'I am Kingsley Okpara, a Python and PHP Fullstack Web developer and tech writer, I also have extensive knowledge and experience with JavaScript while working on applications developed with VueJs.'
        // ];
        // Mail::to($email)->send(new Gmail($details));
        //dd($this->state);
        Validator::make($this->state, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'prescriber_type' => 'required',
            'gender' => 'required',
            'password' => 'required|confirmed',
        ])->validate();
        //$this->state['password'] = bcrypt($this->state['password']);
        //$this->state['admin_type'] = 'admin';

        if ($this->photo) {
            $this->state['profile_photo'] = $this->photo->store('/', 'profiles');
        } else {
            $this->state['profile_photo'] = NULL;
        }

        $this->state['organization_id'] =  Auth::user()->org_id;

        DB::transaction(function () {

            $newPrescriber = Prescriber::create($this->state);

            $newUser = User::create([
                'name' => $this->state['first_name'] . ' ' . $this->state['last_name'],
                'email' => $this->state['email'],
                'profile_photo' => $this->state['profile_photo'],
                'password' => Hash::make($this->state['password']),
                'account_type' => $this->state['is_admin'] ?? false ? 'prescriber-admin' : 'prescriber',
                'account_id' => $newPrescriber->id,
                'org_id' => Auth::user()->org_id,
            ]);

            if ($newUser) {
                $this->dispatchBrowserEvent('hide-prescriber-modal', ['message' => 'Prescriber added successfully!']);
            }
        });
    }

    public function addPrescriber()
    {
        $this->reset('state', 'photo', 'profilePhoto');
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-prescriber-modal');
    }

    public function editPrescriber($prescriberId)
    {
        $this->reset('state', 'photo', 'profilePhoto');
        $this->showEditModal = true;
        $prescriber = DB::table('prescribers')
            ->join('users', 'users.email', '=', 'prescribers.email')
            ->select('prescribers.*', 'users.account_type', 'users.id AS user_id')
            ->where('prescribers.id', $prescriberId)
            ->first();

        $collection = collect($prescriber);
        $this->prescriberId = $prescriber->id;
        $this->userId = $prescriber->user_id;

        $this->state = $collection->toArray();
        $this->state['is_admin'] = $prescriber->account_type == 'prescriber-admin' ? true : false;
        $this->profilePhoto = $prescriber->profile_photo;

        // dd($this->state);

        $this->dispatchBrowserEvent('show-prescriber-modal');
        //dd($admin);
    }

    public function updatePrescriber()
    {
        //dd($this->state);
        $validatedData = Validator::make($this->state, [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'prescriber_type' => 'required',
            'gender' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'password' => 'sometimes|confirmed',
        ])->validate();

        DB::transaction(function () use ($validatedData) {

            if (!empty($validatedData['password'])) {
                $this->editState['password'] = bcrypt($validatedData['password']);
            }
            $this->editState['name'] = $validatedData['first_name'] . ' ' . $validatedData['last_name'];
            $this->editState['email'] = $validatedData['email'];
            if ($this->photo) {
                $this->editState['profile_photo'] = $this->photo->store('/', 'profiles');
                $this->state['profile_photo'] = $this->photo->store('/', 'profiles');
            }

            Prescriber::find($this->prescriberId)->update($this->state);

            $updatedUser = User::where('account_id', $this->prescriberId)
                ->where('account_type', 'like', 'prescriber' . '%')
                ->update($this->editState);

            if ($updatedUser) {
                $this->dispatchBrowserEvent('hide-prescriber-modal', ['message' => 'Prescriber updated successfully!']);
            }
        });
    }



    public function searchPrescriber()
    {
        dd($this->searchTerm);
    }

    public function render()
    {
        $prescribers = DB::table('prescribers')
            ->leftJoin('prescriber_types', 'prescriber_types.id', '=', 'prescribers.prescriber_type')
            ->select('prescribers.*', 'prescriber_types.initial', 'prescriber_types.title')
            ->where('prescribers.organization_id', Auth::user()->org_id)
            ->latest()->paginate(5);
        $prescriberTypes = DB::table('prescriber_types')
            ->select('id', 'title')
            ->get();
        //dd($prescribers);
        return view('livewire.prescribers', ['prescribers' => $prescribers, 'prescriberTypes' => $prescriberTypes]);
    }
}
