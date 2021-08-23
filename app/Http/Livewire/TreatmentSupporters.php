<?php

namespace App\Http\Livewire;

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
        //$this->state['password'] = bcrypt($this->state['password']);
        //$this->state['admin_type'] = 'admin';

        if ($this->photo) {
            $this->state['photo'] = $this->photo->store('/', 'profiles');
        } else {
            $this->state['photo'] = NULL;
        }

        if (empty($this->state['email'])) {
            $this->state['email'] = '';
        }
        $this->state['organization_id'] =  Auth::user()->org_id;

        DB::transaction(function () {

            $newSupporter = TreatmentSupporter::create($this->state);

            $newUser = User::create([
                'name' => $this->state['full_name'],
                'email' => $this->state['email'] == null ? 'supporter_' . $newSupporter->id . '@afyatime.co.tz' : $this->state['email'],
                'profile_photo' => $this->state['photo'],
                'password' => Hash::make($this->state['phone_number']),
                'account_type' =>  'supporter',
                'account_id' => $newSupporter->id,
                'org_id' => Auth::user()->org_id,
            ]);

            if ($newUser) {
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
        $supporter = DB::table('treatment_supporters')
            ->leftJoin('users', 'users.email', '=', 'treatment_supporters.email')
            ->join('full_regions', 'full_regions.district_id', '=', 'treatment_supporters.district_id')
            ->select('treatment_supporters.*', 'users.account_type', 'users.id AS user_id', 'full_regions.region_id')
            ->where('treatment_supporters.id', $supporterId)
            ->first();

        $collection = collect($supporter);
        $this->supporterId = $supporter->id;
        $this->userId = $supporter->user_id;

        $this->state = $collection->toArray();
        $this->profilePhoto = $supporter->photo;

        $this->dispatchBrowserEvent('show-supporter-modal');
        //dd($admin);
    }

    public function updateSupporter()
    {
        //dd($this->state);
        $validatedData = Validator::make($this->state, [
            'full_name' => 'required',
            'email' => 'sometimes|email|unique:users,email,' . $this->userId,
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'location' => 'required',
            'district_id' => 'required',
        ])->validate();

        DB::transaction(function () use ($validatedData) {

            if (!empty($validatedData['email'])) {
                $this->editState['email'] = $validatedData['email'];
            }
            $this->editState['name'] = $validatedData['full_name'];
            if ($this->photo) {
                $img = $this->photo->store('/', 'profiles');
                $this->editState['profile_photo'] = $img;
                $validatedData['photo'] = $img;
            }

            TreatmentSupporter::find($this->supporterId)->update($validatedData);

            $updatedUser = User::where('account_id', $this->supporterId)
                ->where('account_type', 'supporter')
                ->update($this->editState);

            if ($updatedUser) {
                $this->dispatchBrowserEvent('hide-supporter-modal', ['message' => 'Supporter updated successfully!']);
            }
        });
    }



    public function searchPrescriber()
    {
        dd($this->searchTerm);
    }

    public function render()
    {
        $supporters = TreatmentSupporter::where('organization_id', Auth::user()->org_id)->latest()->paginate(5);

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
        return view('livewire.treatment-supporters', ['supporters' => $supporters, 'regions' => $regions]);
    }
}
