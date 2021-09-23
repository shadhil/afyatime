<?php

namespace App\Http\Livewire;

use App\Models\OrganizationType;
use Livewire\Component;

class Home extends Component
{
    public $action;
    public $package;

    public $state = [];

    public function mount($action = null, $package = null)
    {
        $this->action = $action;
        $this->package = $package;
        $this->state = [];
    }

    public function sendMessage()
    {
    }

    public function registerOrg(){
        
    }

    public function render()
    {
        $orgTypes = OrganizationType::all();
        return view('livewire.home', compact('orgTypes'));
    }
}
