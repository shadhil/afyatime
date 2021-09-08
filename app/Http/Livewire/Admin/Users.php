<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Users extends Component
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
            'email' => 'required|email|unique:admins',
            'password' => 'required|confirmed',
        ])->validate();
        $this->state['password'] = bcrypt($validatedData['password']);
        $this->state['admin_type'] = 'admin';

        if ($this->photo) {
            $this->state['profile_img'] = $this->photo->store('/', 'profiles');
        }

        User::create($this->state);

        // session()->flash('message', 'User added successfully!');

        $this->dispatchBrowserEvent('hide-admin-modal', ['message' => 'User added successfully!']);
    }

    public function addAdmin()
    {
        $this->reset();
        $this->state = [];
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-admin-modal');
    }

    public function editdmin(User $user)
    {
        $this->reset();
        $this->showEditModal = true;
        $this->user = $user;
        $this->state = $user->toArray();

        $this->dispatchBrowserEvent('show-admin-modal');
        //dd($admin);
    }

    public function updateAdmin()
    {
        //dd($this->state);
        $validatedData = Validator::make($this->state, [
            'name' => 'required',
            'email' => 'required|email|unique:admins,email,' . $this->admin->id,
            'password' => 'sometimes|confirmed',
            'phone_number' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        ])->validate();

        // $validatedData['admin_type'] = 'admin';
        //dd($validatedData);

        if (!empty($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        }

        //dd('DONE!');
        // if ($this->photo) {
        //     $validatedData['avatar'] = $this->photo->store('/', 'avatars');
        // }
        $this->admin->update($validatedData);

        // session()->flash('message', 'User added successfully!');

        $this->dispatchBrowserEvent('hide-admin-modal', ['message' => 'User updated successfully!']);
    }

    public function confirmAdminRemoval($adminId)
    {
        $this->adminIdBeingRemoved = $adminId;
        $this->dispatchBrowserEvent('show-delete-modal');
    }

    public function deleteAdmin()
    {
        $admin = User::findOrFail($this->adminIdBeingRemoved);

        $admin->delete();

        $this->dispatchBrowserEvent('hide-delete-modal', ['message' => 'Admin deleted successfully!']);
    }

    public function render()
    {
        $users = User::latest()->paginate(5);
        //dd($users);
        return view('livewire.admin.users', ['users' => $users]);
    }
}