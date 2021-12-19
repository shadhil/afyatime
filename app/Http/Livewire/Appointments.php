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

    public $vPatient;
    public $vPrescriber;
    public $vDate;
    public $vTime;
    public $vType;
    public $vReceiver;
    public $vCondition;

    public $searchTerm;

    public function viewAppointmentModal($id, $patient, $prescriber, $date, $time, $type, $condition, $receiver = null, $editable)
    {
        $this->vPatient = $patient;
        $this->vPrescriber = $prescriber;
        $this->vDate = $date;
        $this->vTime = $time;
        $this->vType = Str::ucfirst($type);
        $this->vReceiver = Str::of($receiver)->trim();
        $this->vCondition = $condition;

        // dd($this->vReceiver);

        $this->dispatchBrowserEvent('show-view-modal');
    }


    public function updatedsearchTerm()
    {
        $this->resetPage();
    }

    public function searchAppointment()
    {
        $this->resetPage();
    }

    public function render()
    {
        if ($this->searchTerm != null) {
            $searchTerm = $this->searchTerm;
            $appointments = Appointment::query()
                ->with(['prescriber' => function ($query) {
                    $query->withTrashed();
                }])
                ->where('organization_id', Auth::user()->org_id)
                ->whereHas('patient', function ($query) use ($searchTerm) {
                    $query->where('first_name', 'like', "%{$searchTerm}%")
                        ->orWhere('patients.last_name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('patients.patient_code', 'like', '%' . $searchTerm . '%');
                })
                // ->where(function ($query) {
                //     $query->where('patients.first_name', 'like', '%' . $this->searchTerm . '%')
                //         ->orWhere('patients.last_name', 'like', '%' . $this->searchTerm . '%')
                //         ->orWhere('patients.patient_code', 'like', '%' . $this->searchTerm . '%');
                // })
                ->orderByDesc('date_of_visit')
                ->paginate(10);
        } else {
            $appointments = Appointment::query()
                ->with(['prescriber' => function ($query) {
                    $query->withTrashed();
                }])
                ->where('organization_id', Auth::user()->org_id)
                ->orderByDesc('date_of_visit')
                ->paginate(10);
        }


        return view('livewire.appointments', ['appointments' => $appointments])->layout('layouts.base');
    }
}
