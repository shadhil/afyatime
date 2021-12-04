<?php

namespace App\Http\Livewire;

use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class Appointments extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";


    public $vPrescriber;
    public $vDate;
    public $vTime;
    public $vType;
    public $vReceiver;
    public $vCondition;

    public $searchTerm;

    public function viewAppointmentModal($id, $prescriber, $date, $time, $type, $condition, $receiver = null, $editable)
    {
        $this->vPrescriber = $prescriber;
        $this->vDate = $date;
        $this->vTime = $time;
        $this->vType = Str::ucfirst($type);
        $this->vReceiver = Str::of($receiver)->trim();
        $this->vCondition = $condition;

        // dd($this->vReceiver);

        $this->dispatchBrowserEvent('show-view-modal');
    }

    public function searchAppointment()
    {
    }

    public function render()
    {
        $appointments = Appointment::query()
            ->where('organization_id', Auth::user()->org_id)
            ->orderByDesc('date_of_visit')
            ->paginate(8);

        return view('livewire.appointments', ['appointments' => $appointments])->layout('layouts.base');
    }
}
