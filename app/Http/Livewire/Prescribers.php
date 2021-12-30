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
use Intervention\Image\Facades\Image;

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

    public $canUpdate = 'disabled';

    public $title;
    public $initial;

    public $prescriberAdmin = false;

    public function newCode()
    {
        $testCode = '';
        $isFound = false;
        while (!$isFound) {
            $testCode = Str::before((string) Str::uuid(), '-');
            $code = DB::table('prescribers')
                ->select('prescriber_code')
                ->where('prescriber_code', $testCode)
                ->first();
            if (!$code) {
                $isFound = true;
            }
        }
        return Str::upper($testCode);
    }

    public function mount()
    {
        if (Auth::user()->isAdmin()) {
            $this->canUpdate = '';
        }
    }

    public function createPrescriber()
    {
        //  dd($this->state);

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
                if ($this->photo->isValid()) {
                    $photoName = Prescriber::PATH . '/pr_' . md5(microtime()) . '.' . $this->photo->extension();
                    $ImageFile = Image::make($this->photo);
                    $ImageFile->save($photoName);
                    $this->state['profile_photo'] = '/' . $photoName;
                    // $this->editState['profile_photo'] = '/' . $photoName;
                } else {
                    $this->state['photo'] = NULL;
                }
            } else {
                $this->state['profile_photo'] = NULL;
            }

            $this->state['password'] = Str::random(10);
            $this->state['organization_id'] =  Auth::user()->org_id;
            $this->state['is_admin'] = $this->state['is_admin'] == true ? 1 : 0;
            $phone = Str::replace(' ', '', $this->state['phone_number']);
            $this->state['phone_number'] = Str::start(Str::substr($phone, -9), '0');
            $this->state['prescriber_code'] = $this->newCode();

            // dd('PASS!');

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
                    user_log('9', Auth::user()->account_id, 'prescriber', $newPrescriber->id);
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
        $this->reset(['state', 'editState', 'photo', 'profilePhoto', 'prescriberAdmin']);
        // dd($this->prescriberAdmin);
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

        if (Auth::user()->account_type != 'organization') {
            $this->prescriberAdmin = $this->state['is_admin'];
        }

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
                if ($this->photo->isValid()) {
                    $photoName = Prescriber::PATH . '/pr_' . md5(microtime()) . '.' . $this->photo->extension();
                    $ImageFile = Image::make($this->photo);
                    $ImageFile->save($photoName);
                    $this->state['profile_photo'] = '/' . $photoName;
                    $this->editState['profile_photo'] = '/' . $photoName;
                } else {
                    $this->state['photo'] = NULL;
                }
            }

            $this->state['phone_number'] = trim_phone_number($this->state['phone_number']);

            $updatedPresc = Prescriber::find($this->prescriberId);
            $updatedPresc->update($this->state);

            $updatedPresc->accounts()->update($this->editState);

            if ($updatedPresc) {
                user_log('10', Auth::user()->account_id, 'prescriber', $this->prescriberId);
                $this->dispatchBrowserEvent('hide-prescriber-modal', ['message' => 'Prescriber updated successfully!']);
            }
        });
    }

    public function deleteModal()
    {
        // $this->prescriberId = $prescriberId;
        $this->dispatchBrowserEvent('hide-prescriber-modal', ['message' => 'none']);
        $this->dispatchBrowserEvent('show-delete-modal');
    }

    public function deletePrescriber()
    {
        $prescriber = Prescriber::findOrFail($this->prescriberId);

        $prescriber->delete();

        user_log('11', Auth::user()->account_id, 'prescriber', $this->prescriberId);

        $this->dispatchBrowserEvent('hide-delete-modal', ['message' => 'Prescriber deleted successfully!']);
    }

    public function showTitleModal()
    {
        $this->dispatchBrowserEvent('show-title-modal');
    }

    public function updateTitleRole()
    {
        // dd('Update!');
        $validatedData = $this->validate([
            'title' => 'required',
        ]);

        $orgId = Auth::user()->account->organization_id;

        $titleRole = PrescriberType::query()->where('title', $this->title)->where('org_id', $orgId)->first();

        if ($titleRole) {
            $titleRole->delete();
        } else {
            $titleRole = PrescriberType::create([
                'initial' => $this->initial ?? NULL,
                'title' => $this->title,
                'org_id' => $orgId,
            ]);
        }
        $this->title = '';
        $this->initial = '';

        user_log('17', Auth::user()->account_id, 'prescriber_type', $titleRole->id);

        $this->dispatchBrowserEvent('hide-title-modal');
    }

    public function updatedsearchTerm()
    {
        $this->resetPage();
    }

    public function searchPrescriber()
    {
        $this->resetPage();
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
                ->latest()->limit($this->packageSubscribers)->paginate(4);
        } else {
            $prescribers = Prescriber::query()
                ->where('prescribers.organization_id', Auth::user()->org_id)
                ->latest()->limit($this->packageSubscribers)->paginate(4);
        }

        $prescriberTypes = PrescriberType::query()
            ->where(function ($query) {
                $query->where('org_id', Auth::user()->org_id)
                    ->orWhereNull('org_id');
            })->get();

        // dd($this->packageSubscribers);
        return view('livewire.prescribers', ['prescribers' => $prescribers, 'prescriberTypes' => $prescriberTypes])->layout('layouts.base');
    }
}
