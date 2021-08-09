<?php

namespace App\Http\Livewire\Admin;

use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Admins extends Component
{
    public $state = [];
    public $showEditModal = false;
    public $admin;

    public function createAdmin()
    {
        //dd($this->state);
        $validatedData = Validator::make($this->state, [
            'name' => 'required',
            'email' => 'required|email|unique:admins',
            'password' => 'required|confirmed',
        ])->validate();
        $validatedData['password'] = bcrypt($validatedData['password']);
        $validatedData['admin_type'] = 'admin';
        // dd($validatedData);

        // if ($this->photo) {
        //     $validatedData['avatar'] = $this->photo->store('/', 'avatars');
        // }

        Admin::create($this->state);

        // session()->flash('message', 'User added successfully!');

        $this->dispatchBrowserEvent('hide-admin-modal', ['message' => 'User added successfully!']);
    }

    public function addAdmin()
    {
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-admin-modal');
    }

    public function editdmin(Admin $admin)
    {
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
            'email' => 'required|email|unique:admins,email,' . $this->admin->id,
            'password' => 'sometimes|confirmed',
        ])->validate();

        // $validatedData['admin_type'] = 'admin';
        // dd($validatedData);

        if (!empty($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        }

        //dd('DONE!');
        // if ($this->photo) {
        //     $validatedData['avatar'] = $this->photo->store('/', 'avatars');
        // }
        $this->admin->update($validatedData);
       
        // session()->flash('message', 'User added successfully!');

        $this->dispatchBrowserEvent('hide-admin-modal', ['message' => 'User added successfully!']);
    }

    public function render()
    {
        $admins = Admin::latest()->get();
        //dd($admins);
        return view('livewire.admin.admins', ['admins' => $admins]);
    }
}
