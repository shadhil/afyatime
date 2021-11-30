<?php

namespace App\Http\Livewire\Admin;

use App\Models\Appointment;
use Livewire\Component;

class AllAppointments extends Component
{
    public function render()
    {

        $appointments = Appointment::query()
            ->orderByDesc('date_of_visit')
            ->paginate(20);

        return view('livewire.admin.all-appointments', compact('appointments'));
    }
}
