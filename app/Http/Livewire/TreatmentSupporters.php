<?php

namespace App\Http\Livewire;

use App\Models\OrganizationSubscription;
use App\Models\TreatmentSupporter;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class TreatmentSupporters extends Component
{

    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = "bootstrap";

    public $state = [];
    public $editState = [];

    public $showEditModal = false;

    public $supporterId = null;
    public $userId = null;

    public $searchTerm = null;

    public $photo;
    public $profilePhoto;

    public $districts = [];

    public $packageStatus = 4;

    public function mount($new = null)
    {
        if ($new == 'new') {
            dd('NEW!');
        }
    }

    public function createSupporter()
    {
        // dd($this->newCode());
        Validator::make($this->state, [
            'full_name' => 'required',
            'email' => 'sometimes|email|unique:users',
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'location' => 'required',
            'district_id' => 'required',
        ])->validate();

        if ($this->photo) {
            $this->state['photo'] = $this->photo->store('/', 'profiles');
        } else {
            $this->state['photo'] = NULL;
        }

        if (empty($this->state['email'])) {
            $this->state['email'] = NULL;
        }
        $this->state['organization_id'] = Auth::user()->org_id;
        $this->state['phone_number'] = trim_phone_number($this->state['phone_number']);

        DB::transaction(function () {
            $newSupporter = TreatmentSupporter::create($this->state);
            if ($this->state['email'] != NULL) {
                $newSupporter->accounts()->create([
                    'name' => $this->state['full_name'],
                    'email' => $this->state['email'],
                    'profile_photo' => $this->state['photo'],
                    'password' => Hash::make($this->state['phone_number']),
                    'org_id' => Auth::user()->org_id,
                ]);
            }
            if ($newSupporter) {
                $this->dispatchBrowserEvent('hide-supporter-modal', ['message' => 'Supporter added successfully!']);
            }
        });
    }

    public function addSupporter()
    {
        $this->reset('state', 'photo', 'profilePhoto', 'supporterId');
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-supporter-modal');
    }

    public function editSupporter($supporterId)
    {
        $this->reset('state', 'photo', 'profilePhoto', 'supporterId');
        $this->showEditModal = true;
        $supporter = TreatmentSupporter::find($supporterId);

        $this->supporterId = $supporter->id;
        $this->profilePhoto = $supporter->photo;

        $user = $supporter->accounts()->where('account_id', $supporterId)->first();
        // dd($user);
        if ($user != null) {
            $this->userId = $user->id;
        } else {
            $this->userId = null;
        }

        $this->state = $supporter->toArray();
        $this->state['region_id'] = $supporter->district->region_id;
        $this->state['district_id'] = $supporter->district_id;

        $this->dispatchBrowserEvent('show-supporter-modal');
        //dd($admin);
    }

    public function updateSupporter()
    {
        $this->state['user_id'] = $this->userId;
        //dd($this->state);
        $validatedData = Validator::make($this->state, [
            'full_name' => 'required',
            'email' => 'exclude_if:user_id,null|sometimes|email|unique:users,email,' . $this->userId,
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'location' => 'required',
            'district_id' => 'required',
        ])->validate();

        DB::transaction(function () use ($validatedData) {

            if (!empty($validatedData['email'])) {
                $this->editState['email'] = $validatedData['email'];
            }
            $validatedData['phone_number'] = trim_phone_number($validatedData['phone_number']);
            $this->editState['name'] = $validatedData['full_name'];
            if ($this->photo) {
                $img = $this->photo->store('/', 'profiles');
                $this->editState['profile_photo'] = $img;
                $validatedData['photo'] = $img;
            }

            $updatedSupporter = TreatmentSupporter::find($this->supporterId);
            $updatedSupporter->update($validatedData);

            $updatedSupporter->accounts()->update($this->editState);

            if ($updatedSupporter) {
                $this->dispatchBrowserEvent('hide-supporter-modal', ['message' => 'Supporter updated successfully!']);
            }
        });
    }

    public function supporterRemoval($supporterId)
    {
        $this->supporterId = $supporterId;
        $this->dispatchBrowserEvent('show-delete-modal');
    }

    public function deleteSupporter()
    {
        $supporter = TreatmentSupporter::findOrFail($this->supporterId);

        $supporter->delete();

        $this->dispatchBrowserEvent('hide-delete-modal', ['message' => 'Appointment deleted successfully!']);
    }


    public function searchSupporter()
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
            $this->packageStatus = 4;
        } else {
            $this->packageStatus = $orgSub->status;
        }

        if ($this->searchTerm != null) {
            $supporters = TreatmentSupporter::query()
                ->where('organization_id', Auth::user()->org_id)
                ->where('full_name', 'like', '%' . $this->searchTerm . '%')
                ->latest()->paginate(15);
        } else {
            $supporters = TreatmentSupporter::query()
                ->where('organization_id', Auth::user()->org_id)
                ->latest()->paginate(15);
        }


        if (!empty($this->state['region_id'])) {
            $this->districts = DB::table('districts')
                ->select('id', 'name')
                ->where('region_id', $this->state['region_id'])
                ->get();
        } else {
            $this->districts = [];
        }

        $regions = DB::table('regions')
            ->select('id', 'name')
            ->get();
        //dd($prescribers);
        return view('livewire.treatment-supporters', ['supporters' => $supporters, 'regions' => $regions])->layout('layouts.base');
    }
}
