<?php

namespace App\Http\Livewire\Admin;

use App\Events\OrganizationRegistered;
use App\Jobs\WelcomeOrganizationJob;
use App\Models\Admin;
use App\Models\Appointment;
use App\Models\Organization;
use App\Models\OrganizationSubscription;
use App\Models\OrganizationType;
use App\Models\Patient;
use App\Models\Prescriber;
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

class Organizations extends Component
{
    use WithFileUploads;
    use WithPagination;

    protected $paginationTheme = "bootstrap";

    public $state = [];
    public $editState = [];
    public $districts = [];

    //public $organization;

    public $logo;
    public $orgLogo;

    public $showEditModal = false;

    public $orgId = null;

    public $searchTerm = null;

    public $totalPatients;
    public $totalAppointments;
    public $totalPrescribers;
    public $totalSupporters;

    public function createOrg()
    {
        // dd($this->state);
        Validator::make($this->state, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'location' => 'required',
            'region_id' => 'required',
            'district_id' => 'required',
            'organization_type' => 'required',
            'known_as' => 'string',
            // 'password' => 'required|confirmed',
        ])->validate();

        if ($this->logo) {
            $this->state['logo'] = $this->logo->store('/', 'profiles');
        } else {
            $this->state['logo'] = NULL;
        }

        $this->state['password'] = Str::random(10);
        if (empty($this->state['known_as'])) {
            $this->state['known_as'] = $this->state['name'];
        }
        $phone = Str::replace(' ', '', $this->state['phone_number']);
        $this->state['phone_number'] = Str::start(Str::substr($phone, -9), '0');
        //$this->state['admin_type'] = 'admin';

        DB::transaction(function () {

            $newOrg = Organization::create($this->state);

            $newOrg->accounts()->create([
                'name' => $this->state['name'],
                'email' => $this->state['email'],
                'profile_photo' => $this->state['logo'],
                'password' => Hash::make($this->state['password']),
                'org_id' => $newOrg->id,
            ]);

            if ($newOrg) {
                $this->dispatchBrowserEvent('hide-org-modal', ['message' => 'Organization added successfully!']);
                $details = [
                    'name' => $this->state['name'],
                    'email' => $this->state['email'],
                    'password' => $this->state['password'],
                ];
                WelcomeOrganizationJob::dispatch($details);
                // event(new OrganizationRegistered($details));
            }
        });
    }

    public function addOrg()
    {
        $this->reset('state', 'logo', 'orgLogo', 'orgId');
        $this->state = [];
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-org-modal');
    }

    public function editOrg($orgId)
    {
        $this->reset('state', 'logo', 'orgLogo', 'orgId');
        $this->showEditModal = true;
        $organization = DB::table('organizations')
            ->join('full_regions', 'organizations.district_id', '=', 'full_regions.district_id')
            ->select('organizations.*', 'full_regions.region_id')
            ->where('organizations.id', $orgId)
            ->first();

        $collection = collect($organization);
        $this->orgId = $organization->id;
        $this->orgLogo = $organization->logo;

        $this->state = $collection->toArray();
        //dd($this->orgId);
        $this->dispatchBrowserEvent('show-org-modal');
        //dd($organization);
    }

    public function updateOrg()
    {
        //dd($this->state);
        $validatedData = Validator::make($this->state, [
            'name' => 'required',
            'email' => 'required|email|unique:organizations,email,' . $this->orgId,
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'location' => 'required',
            'region_id' => 'required',
            'district_id' => 'required',
            'known_as' => 'required',
            'organization_type' => 'required',
            'password' => 'sometimes|confirmed',
        ])->validate();

        DB::transaction(function () use ($validatedData) {

            if (!empty($validatedData['password'])) {
                $this->editState['password'] = Hash::make($validatedData['password']);
            }
            $this->editState['name'] = $validatedData['name'];
            $this->editState['email'] = $validatedData['email'];

            if (empty($this->state['known_as'])) {
                $this->editState['known_as'] = $this->state['name'];
            }
            $phone = Str::replace(' ', '', $this->state['phone_number']);
            $this->state['phone_number'] = Str::start(Str::substr($phone, -9), '0');

            $updatedOrg = Organization::find($this->orgId);
            $updatedOrg->update($this->state);
            // $this->organization->update($this->state);

            $updatedOrg->accounts()->update($this->editState);

            if ($updatedOrg) {
                $this->dispatchBrowserEvent('hide-org-modal', ['message' => 'Organization updated successfully!']);
            }



            // $newUser = User::update([
            //     'name' => $this->state['name'),
            //     'email' => $this->state['email'),
            //     'password' => Hash::make($this->state['password')),
            //     'account_type' => 'organization',
            //     'account_id' => $newOrg->id,
            // ]);


        });

        // $this->admin->update($validatedData);

    }

    public function confirmOrgRemoval($orgId)
    {
        $this->orgId = $orgId;
        $this->dispatchBrowserEvent('show-delete-modal');
    }

    public function deleteOrg()
    {
        $organization = Organization::findOrFail($this->orgId);

        $organization->delete();

        $this->dispatchBrowserEvent('hide-delete-modal', ['message' => 'Organization deleted successfully!']);
    }

    public function updatedsearchTerm()
    {
        $this->resetPage();
    }

    public function searchOrganization()
    {
        $this->resetPage();
        // dd($this->searchTerm);
    }

    public function render()
    {
        $orgTypes = OrganizationType::get();

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

        $packages = DB::table('subscription_packages')
            ->get();

        if ($this->searchTerm != null) {
            $organizations = Organization::query()
                ->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('email', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('phone_number', 'like', '%' . $this->searchTerm . '%');
                })
                ->latest()->paginate(4);
        } else {
            $organizations = Organization::query()->latest()->paginate(6);
        }

        $this->totalPatients = Patient::count();

        $this->totalAppointments = Appointment::count();

        $this->totalPrescribers = Prescriber::count();

        $this->totalSupporters = TreatmentSupporter::count();

        // $organizations = Organization::query()->paginate(6);
        // $org = $organizations[0];
        // dd($org->latestSubscription->status());
        return view('livewire.admin.organizations', ['organizations' => $organizations, 'orgTypes' => $orgTypes, 'regions' => $regions, 'packages' => $packages])->layout('layouts.admin-base');
    }
}
