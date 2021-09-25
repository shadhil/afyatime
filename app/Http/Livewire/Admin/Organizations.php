<?php

namespace App\Http\Livewire\Admin;

use App\Events\OrganizationRegistered;
use App\Jobs\WelcomeOrganizationJob;
use App\Models\Admin;
use App\Models\Organization;
use App\Models\OrganizationSubscription;
use App\Models\OrganizationType;
use App\Models\User;
use Carbon\Carbon;
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

    public $showEditModal = false;

    public $orgIdSelected = null;

    public $searchTerm = null;

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
        $this->reset('state');
        $this->state = [];
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-org-modal');
    }

    public function editOrg($orgId)
    {
        $this->reset('state');
        $this->showEditModal = true;
        $organization = DB::table('organizations')
            ->join('full_regions', 'organizations.district_id', '=', 'full_regions.district_id')
            ->select('organizations.*', 'full_regions.region_id')
            ->where('organizations.id', $orgId)
            ->first();

        $collection = collect($organization);
        $this->orgIdSelected = $organization->id;

        $this->state = $collection->toArray();
        //dd($this->orgIdSelected);
        $this->dispatchBrowserEvent('show-org-modal');
        //dd($organization);
    }

    public function updateOrg()
    {
        //dd($this->state);
        $validatedData = Validator::make($this->state, [
            'name' => 'required',
            'email' => 'required|email|unique:organizations,email,' . $this->orgIdSelected,
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
            $this->editState['phone_number'] = Str::start(Str::substr($phone, -9), '0');

            $updatedOrg = Organization::find($this->orgIdSelected);
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
        $this->orgIdSelected = $orgId;
        $this->dispatchBrowserEvent('show-delete-modal');
    }

    public function deleteOrg()
    {
        $organization = Organization::findOrFail($this->orgIdSelected);

        $organization->delete();

        $this->dispatchBrowserEvent('hide-delete-modal', ['message' => 'Organization deleted successfully!']);
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
        //dd($admins);
        $packages = DB::table('subscription_packages')
            ->get();

        // $organizations = DB::table('organizations')
        //     ->join('full_regions', 'full_regions.district_id', '=', 'organizations.district_id')
        //     ->select('organizations.*', 'full_regions.region', 'full_regions.district', DB::raw("(SELECT COUNT(prescribers.id) FROM prescribers WHERE prescribers.organization_id = organizations.id GROUP BY prescribers.organization_id) as prescribers"), DB::raw("(SELECT COUNT(patients.id) FROM patients WHERE patients.organization_id = organizations.id GROUP BY patients.organization_id) as patients"), DB::raw("(SELECT COUNT(treatment_supporters.id) FROM treatment_supporters WHERE treatment_supporters.organization_id = organizations.id GROUP BY treatment_supporters.organization_id) as supporters"), DB::raw("(SELECT COUNT(appointments.id) FROM appointments WHERE appointments.organization_id = organizations.id GROUP BY appointments.organization_id) as appointments"))
        //     ->groupBy('organizations.id')
        //     ->paginate(5);
        // dd($organizations);

        $organizations = Organization::query()->paginate(6);
        // $org = $organizations[0];
        // dd($org->subscriptions()->latest()->first());
        return view('livewire.admin.organizations', ['organizations' => $organizations, 'orgTypes' => $orgTypes, 'regions' => $regions, 'packages' => $packages]);
    }
}
