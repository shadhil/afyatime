<?php

namespace App\Http\Livewire;

use App\Models\Prescriber;
use App\Models\UserLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PrescriberProfile extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $prescriberId;
    public $prescriberCode;

    public $vPatient;
    public $vPrescriber;
    public $vDate;
    public $vTime;
    public $vType;
    public $vReceiver;
    public $vCondition;

    public $searchTerm;

    public $state = [];
    public $editState = [];

    public $showEditModal = false;

    public $userId = null;
    public $packageSubscribers = 2;
    public $packageStatus = 1;

    public $browsed_photo;
    public $profilePhoto;

    public $phone_number;
    public $email;
    public $password;
    public $password_confirmation;
    public $photo;


    public function mount($id = 'null')
    {
        if ($id == 'null') {
            $this->prescriberCode = Auth::user()->account->prescriber_code;
            $this->prescriberId = Auth::user()->account_id;
        } else {
            $this->prescriberCode = $id;
            $presc = DB::table('prescribers')->select('id')->where('prescriber_code', $id)->first();
            $this->prescriberId = $presc->id;
        }
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


    public function editPrescriber()
    {
        $this->reset(['phone_number', 'email', 'password', 'browsed_photo', 'profilePhoto']);
        // dd($this->prescriberAdmin);
        $this->showEditModal = true;

        $prescriber = Prescriber::find($this->prescriberId);
        // $collection = collect($prescriber);
        $this->prescriberId = $prescriber->id;
        $this->profilePhoto = $prescriber->profile_photo;
        $this->phone_number = $prescriber->phone_number;
        $this->email = $prescriber->email;


        $user = $prescriber->accounts()->where('account_id', $this->prescriberId)->first();
        $this->userId = $user->id;
        $this->state['is_admin'] = $user->is_admin == 1 ? true : false;

        $this->dispatchBrowserEvent('show-prescriber-modal');
        //dd($admin);
    }

    public function updatePrescriber()
    {
        //dd($this->state);
        $validatedData = $this->validate([
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'password' => 'sometimes|confirmed',
            'browsed_photo' => 'nullable|image|max:1024',
        ]);

        DB::transaction(function () use ($validatedData) {

            if (!empty($validatedData['password'])) {
                $validatedData['password'] = bcrypt($validatedData['password']);
                $this->editState['password'] = $validatedData['password'];
            }

            $this->editState['email'] = $validatedData['email'];
            if ($validatedData['browsed_photo'] != null) {
                if ($this->browsed_photo->isValid()) {
                    $photoName = Prescriber::PATH . '/pr_' . md5(microtime()) . '.' . $this->browsed_photo->extension();
                    $ImageFile = Image::make($this->browsed_photo);
                    $ImageFile->save($photoName);
                    $this->validatedData['photo'] = '/' . $photoName;
                    // $this->photo = '/' . $photoName;
                    $this->editState['profile_photo'] = '/' . $photoName;
                }
            }

            $validatedData['phone_number'] = trim_phone_number($validatedData['phone_number']);

            $updatedPresc = Prescriber::find($this->prescriberId);
            $updatedPresc->update($validatedData);

            $updatedPresc->accounts()->update($this->editState);

            if ($updatedPresc) {
                // user_log('10', Auth::user()->account_id, 'prescriber', $this->prescriberId);
                $this->dispatchBrowserEvent('hide-prescriber-modal', ['message' => 'Profile updated successfully!']);
            }
        });
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
                    ->where('organization_id', Auth::user()->org_id)
                    ->orderByDesc('date_of_visit')
                    ->paginate(12);
            } else {
                $appointments = $prescriber->appointments()
                    ->where('organization_id', Auth::user()->org_id)
                    ->orderByDesc('date_of_visit')
                    ->paginate(12);
            }
        } else {
            $prescriber = [];
        }

        return view('livewire.prescriber-profile', compact(['prescriber', 'appointments']))->layout('layouts.base');
    }
}
