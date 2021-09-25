<?php

namespace App\Http\Livewire;

use App\Events\PrescriberRegistered;
use App\Jobs\WelcomePrescriberJob;
use App\Mail\Gmail;
use App\Models\Organization;
use App\Models\OrganizationSubscription;
use App\Models\Prescriber;
use App\Models\PrescriberType;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class Prescribers extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = "bootstrap";

    public $state = [];
    public $editState = [];

    public $showEditModal = false;

    public $prescriberId = null;
    public $userId = null;
    public $packageSubscribers = 2;
    public $packageStatus = 1;

    public $searchTerm = null;

    public $photo;
    public $profilePhoto;

    public function createPrescriber()
    {
        // dd($this->packageSubscribers);

        $allPrescribers = Prescriber::query()
            ->where('organization_id', Auth::user()->org_id)
            ->count();

        if ($allPrescribers >= $this->packageSubscribers) {
            $this->dispatchBrowserEvent('show-error-toastr', ['message' => 'You subscription package can not allow you to add a new Prescriber, upgrade your package!']);
        } else {

            Validator::make($this->state, [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users',
                'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                'prescriber_type' => 'required',
                'gender' => 'required',
            ])->validate();
            //$this->state['password'] = bcrypt($this->state['password']);
            //$this->state['admin_type'] = 'admin';

            if ($this->photo) {
                $this->state['profile_photo'] = $this->photo->store('/', 'profiles');
            } else {
                $this->state['profile_photo'] = NULL;
            }

            $this->state['password'] = Str::random(10);
            $this->state['organization_id'] =  Auth::user()->org_id;
            $this->state['is_admin'] = $this->state['is_admin'] == true ? 1 : 0;
            $phone = Str::replace(' ', '', $this->state['phone_number']);
            $this->state['phone_number'] = Str::start(Str::substr($phone, -9), '0');

            DB::transaction(function () {

                $newPrescriber = Prescriber::create($this->state);

                $newPrescriber->accounts()->create([
                    'name' => $this->state['first_name'] . ' ' . $this->state['last_name'],
                    'email' => $this->state['email'],
                    'profile_photo' => $this->state['profile_photo'],
                    'password' => Hash::make($this->state['password']),
                    'org_id' => Auth::user()->org_id,
                    'is_admin' => $this->state['is_admin'],
                ]);

                if ($newPrescriber) {
                    $this->dispatchBrowserEvent('hide-prescriber-modal', ['message' => 'Prescriber added successfully!']);
                    $details = [
                        'name' => $this->state['first_name'] . ' ' . $this->state['last_name'],
                        'email' => $this->state['email'],
                        'password' => $this->state['password'],
                        'organization' => $newPrescriber->organization->name,
                    ];
                    WelcomePrescriberJob::dispatch($details);
                }
            });
        }
    }

    public function addPrescriber()
    {
        $this->reset('state', 'photo', 'profilePhoto');
        $this->showEditModal = false;
        $this->state['is_admin'] = false;
        $this->dispatchBrowserEvent('show-prescriber-modal');
    }

    public function editPrescriber($prescriberId)
    {
        $this->reset('state', 'photo', 'profilePhoto');
        $this->showEditModal = true;
        // $prescriber = DB::table('prescribers')
        //     ->join('users', 'users.email', '=', 'prescribers.email')
        //     ->select('prescribers.*', 'users.account_type', 'users.id AS user_id')
        //     ->where('prescribers.id', $prescriberId)
        //     ->first();
        $prescriber = Prescriber::find($prescriberId);
        // $collection = collect($prescriber);
        $this->prescriberId = $prescriber->id;
        $this->profilePhoto = $prescriber->profile_photo;

        $this->state = $prescriber->toArray();

        $user = $prescriber->accounts()->where('account_id', $prescriberId)->first();
        $this->userId = $user->id;
        $this->state['is_admin'] = $user->is_admin == 1 ? true : false;

        // dd($this->state);

        $this->dispatchBrowserEvent('show-prescriber-modal');
        //dd($admin);
    }

    public function updatePrescriber()
    {
        //dd($this->state);
        $validatedData = Validator::make($this->state, [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'prescriber_type' => 'required',
            'gender' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'password' => 'sometimes|confirmed',
        ])->validate();

        DB::transaction(function () use ($validatedData) {

            if (!empty($validatedData['password'])) {
                $this->editState['password'] = bcrypt($validatedData['password']);
            }
            $this->editState['name'] = $validatedData['first_name'] . ' ' . $validatedData['last_name'];
            $this->editState['email'] = $validatedData['email'];
            if ($this->photo) {
                $this->editState['profile_photo'] = $this->photo->store('/', 'profiles');
                $this->state['profile_photo'] = $this->photo->store('/', 'profiles');
            }

            $this->state['phone_number'] = trim_phone_number($this->state['phone_number']);

            $updatedPresc = Prescriber::find($this->prescriberId);
            $updatedPresc->update($this->state);

            $updatedPresc->accounts()->update($this->editState);

            if ($updatedPresc) {
                $this->dispatchBrowserEvent('hide-prescriber-modal', ['message' => 'Prescriber updated successfully!']);
            }
        });
    }

    public function deleteModal($prescriberId)
    {
        $this->prescriberId = $prescriberId;
        $this->dispatchBrowserEvent('show-delete-modal');
    }

    public function deletePrescriber()
    {
        $prescriber = Prescriber::findOrFail($this->prescriberId);

        $prescriber->delete();

        $this->dispatchBrowserEvent('hide-delete-modal', ['message' => 'Prescriber deleted successfully!']);
    }



    public function searchPrescriber()
    {
        // dd($this->searchTerm);
    }

    public function render()
    {
        $orgSub = OrganizationSubscription::query()
            ->where('organization_id', Auth::user()->org_id)
            ->where('status', 2)
            ->latest()->first();
        if ($orgSub == null) {
            $this->packageSubscribers = 0;
            $this->packageStatus = 4;
        } else {
            $this->packageSubscribers = $orgSub->package->max_prescribers;
            $this->packageStatus = $orgSub->status;
        }
        // dd($orgSub->package->max_prescribers);

        if ($this->searchTerm != null) {
            $prescribers = Prescriber::query()
                ->where('organization_id', Auth::user()->org_id)
                ->where(function ($query) {
                    $query->where('first_name', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%');
                })
                ->latest()->limit($this->packageSubscribers)->paginate(15);
        } else {
            $prescribers = Prescriber::query()
                ->where('prescribers.organization_id', Auth::user()->org_id)
                ->latest()->limit($this->packageSubscribers)->paginate(15);
        }

        $prescriberTypes = PrescriberType::all();

        // dd($this->packageSubscribers);
        return view('livewire.prescribers', ['prescribers' => $prescribers, 'prescriberTypes' => $prescriberTypes]);
    }
}
