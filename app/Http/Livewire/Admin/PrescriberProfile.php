<?php

namespace App\Http\Livewire\Admin;

use App\Models\Prescriber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class PrescriberProfile extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $prescriberId;
    public $prescriberCode;
    public $orgId;

    public $vPatient;
    public $vPrescriber;
    public $vDate;
    public $vTime;
    public $vType;
    public $vReceiver;
    public $vCondition;

    public $searchTerm;

    public function mount($id = 'null', $org_id)
    {
        $this->prescriberCode = $id;
        $presc = DB::table('prescribers')->select('id')->where('prescriber_code', $id)->first();
        $this->prescriberId = $presc->id;
        $this->orgId = $org_id;
    }

    public function viewAppointmentModal($id, $prescriber, $date, $time, $type, $condition, $receiver = null, $prescriber_id)
    {
        $this->appointmentId = $id;
        $this->vPrescriber = $prescriber;
        $this->vDate = $date;
        $this->vTime = $time;
        $this->vType = Str::ucfirst($type);
        $this->vReceiver = Str::of($receiver)->trim();
        $this->vCondition = $condition;

        if (Auth::user()->isAdmin() || $prescriber_id == Auth::user()->account->id) {
            $this->showEditModal = true;
        } else {
            $this->showEditModal = false;
        }
        // dd($this->showEditModal);

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
        $prescriber = Prescriber::where('id', $this->prescriberId)->first();
        $appointments = [];

        // dd($prescriber);
        if ($prescriber != null) {
            if ($this->searchTerm != null) {
                $searchTerm = $this->searchTerm;
                $appointments = $prescriber->appointments()
                    ->whereHas(
                        'patient',
                        function ($query) use ($searchTerm) {
                            $query->where('first_name', 'like', "%{$searchTerm}%")
                                ->orWhere('patients.last_name', 'like', '%' . $searchTerm . '%')
                                ->orWhere('patients.patient_code', 'like', '%' . $searchTerm . '%');
                        }
                    )
                    ->where('organization_id', $this->orgId)
                    ->orderByDesc('date_of_visit')
                    ->paginate(1);
            } else {
                $appointments = $prescriber->appointments()
                    ->where('organization_id', $this->orgId)
                    ->orderByDesc('date_of_visit')
                    ->paginate(1);
            }
        } else {
            $prescriber = [];
        }

        return view('livewire.admin.prescriber-profile', compact(['prescriber', 'appointments']))->layout('layouts.admin-base');
    }
}
