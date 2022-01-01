<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Admins extends Component
{
    use WithFileUploads;
    use WithPagination;

    protected $paginationTheme = "bootstrap";

    public $state = [];

    public $admin;

    public $showEditModal = false;

    public $adminIdBeingRemoved = null;

    public $searchTerm = null;

    public $photo;

    public function createAdmin()
    {
        // dd($this->state);
        $validatedData = Validator::make($this->state, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ])->validate();

        if ($this->photo) {
            // $this->state['profile_photo'] = $this->photo->store('/', 'profiles');
        }

        $user = User::create([
            'name' => $this->state['name'],
            'email' => $this->state['email'],
            'phone_number' => $this->state['phone_number'],
            'password' => bcrypt($this->state['password']),
            'account_type' => 'Admin',
            'account_id' => '0',
            'org_id' => NULL,
        ]);

        admin_log('22', Auth::user()->id, 'user', $user->id);

        // session()->flash('message', 'User added successfully!');

        $this->dispatchBrowserEvent('hide-admin-modal', ['message' => 'Admin added successfully!']);
    }

    public function addAdmin()
    {
        $this->reset();
        $this->state = [];
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-admin-modal');
    }

    public function editdmin(User $admin)
    {
        $this->reset();
        $this->showEditModal = true;
        $this->admin = $admin;
        $this->state = $admin->toArray();

        $this->dispatchBrowserEvent('show-admin-modal');
        //dd($admin);
    }

    public function updateAdmin()
    {
        //dd($this->state);
        $validatedData = Validator::make($this->state, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->admin->id,
            'password' => 'sometimes|confirmed',
            'phone_number' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        ])->validate();

        if (!empty($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        }

        $this->admin->update($validatedData);

        admin_log('23', Auth::user()->id, 'user', $this->admin->id);

        $this->dispatchBrowserEvent('hide-admin-modal', ['message' => 'Admin updated successfully!']);
    }

    public function confirmAdminRemoval($adminId)
    {
        $this->adminIdBeingRemoved = $adminId;
        $this->dispatchBrowserEvent('show-delete-modal');
    }

    public function deleteAdmin()
    {
        $admin = User::findOrFail($this->adminIdBeingRemoved);

        admin_log('24', Auth::user()->id, 'user', $admin->id, $admin->id . ' - ' . $admin->name);

        $admin->delete();

        $this->dispatchBrowserEvent('hide-delete-modal', ['message' => 'Admin deleted successfully!']);
    }

    public function render()
    {
        $admins = User::where('account_type', 'Admin')->latest()->paginate(5);
        //dd($admins);
        return view('livewire.admin.admins', ['admins' => $admins])->layout('layouts.admin-base');
    }
}
