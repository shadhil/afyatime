<?php

namespace App\Http\Livewire;

use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Appointments extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public function render()
    {
        $appointments = Appointment::query()
            ->where('organization_id', Auth::user()->org_id)
            ->orderByDesc('date_of_visit')
            ->paginate(1);

        return view('livewire.appointments', ['appointments' => $appointments])->layout('layouts.base');
    }
}
