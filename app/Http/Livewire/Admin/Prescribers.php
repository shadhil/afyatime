<?php

namespace App\Http\Livewire\Admin;

use App\Jobs\WelcomePrescriberJob;
use App\Models\Prescriber;
use App\Models\PrescriberType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Livewire\WithFileUploads;

class Prescribers extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $orgId;
    public $orgName;

    public $state = [];
    public $editState = [];

    public $showEditModal = false;

    public $prescriberId = null;
    public $userId = null;

    public $searchTerm = null;

    public $photo;
    public $profilePhoto;

    public $canUpdate = '';

    public $title;
    public $initial;

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

    public function mount($id)
    {
        $this->orgId = $id;

        $org = DB::table('organizations')->select('name')->where('id', $id)->first();
        $this->orgName = $org->name;
    }

    public function createPrescriber()
    {

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
        $this->state['organization_id'] =  $this->orgId;
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
                'org_id' => $this->orgId,
                'is_admin' => $this->state['is_admin'],
            ]);

            if ($newPrescriber) {
                admin_log('9', Auth::user()->id, 'prescriber', $newPrescriber->id);
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

    public function addPrescriber()
    {
        $this->reset('state', 'photo', 'profilePhoto');
        $this->showEditModal = false;
        $this->state['is_admin'] = true;
        $this->dispatchBrowserEvent('show-prescriber-modal');
    }

    public function editPrescriber($prescriberId)
    {
        $this->reset(['state', 'editState', 'photo', 'profilePhoto']);
        $this->showEditModal = true;
        $prescriber = Prescriber::find($prescriberId);
        // $collection = collect($prescriber);
        $this->prescriberId = $prescriber->id;
        $this->profilePhoto = $prescriber->profile_photo;

        $this->state = $prescriber->toArray();

        $user = $prescriber->accounts()->where('account_id', $prescriberId)->first();
        $this->userId = $user->id;
        $this->state['is_admin'] = $user->is_admin == 1 ? true : false;

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
                admin_log('10', Auth::user()->id, 'prescriber', $this->prescriberId);
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

        $note = $this->prescriberId . ' - ' . $prescriber->first_name . ' ' . $prescriber->last_name;

        $prescriber->delete();

        admin_log('11', Auth::user()->id, 'prescriber', $this->prescriberId, $note);

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

        $titleRole = PrescriberType::query()->where('title', $this->title)->where('org_id', $this->orgId)->first();

        if ($titleRole) {
            $titleRole->delete();
        } else {
            $titleRole = PrescriberType::create([
                'initial' => $this->initial ?? NULL,
                'title' => $this->title,
                'org_id' => $this->orgId,
            ]);
        }
        $this->title = '';
        $this->initial = '';

        // admin_log('17', Auth::user()->id, 'prescriber_type', $titleRole->id);

        $this->dispatchBrowserEvent('hide-title-modal');
    }

    public function render()
    {
        if ($this->searchTerm != null) {
            $prescribers = Prescriber::query()
                ->where('organization_id', $this->orgId)
                ->where(function ($query) {
                    $query->where('first_name', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%');
                })
                ->latest()->limit(16)->paginate(4);
        } else {
            $prescribers = Prescriber::query()
                ->where('prescribers.organization_id', $this->orgId)
                ->latest()->limit(16)->paginate(4);
        }

        $prescriberTypes = PrescriberType::query()
            ->where(function ($query) {
                $query->where('org_id', $this->orgId)
                    ->orWhereNull('org_id');
            })->get();

        return view('livewire.admin.prescribers', ['prescribers' => $prescribers, 'prescriberTypes' => $prescriberTypes])->layout('layouts.admin-base');
    }
}
