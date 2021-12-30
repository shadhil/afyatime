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
use Intervention\Image\Facades\Image;

class TreatmentSupporters extends Component
{

    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = "bootstrap";

    // public $state = [];
    // public $editState = [];

    public $viewState = [];

    public $showEditModal = false;

    public $supporterId = null;
    public $userId = null;

    public $searchTerm = null;

    public $photo;
    public $profilePhoto;

    public $districts = [];

    public $packageStatus = 4;

    public $new;

    public $full_name;
    public $browsed_photo;
    public $phone_number;
    public $email;
    public $location;
    public $region_id;
    public $district_id;
    public $organization_id;

    public function mount($new = null)
    {
        $this->new = $new;
    }

    public function createSupporter()
    {
        // dd($this->newCode());
        $validatedData = $this->validate(
            [
                'full_name' => 'required',
                'email' => 'nullable|email|unique:users',
                'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                'location' => 'required',
                'district_id' => 'required',
                'browsed_photo' => 'nullable|image|max:1024',
            ]
        );
        // dd($validatedData);


        if ($validatedData['browsed_photo'] != null) {
            if ($this->browsed_photo->isValid()) {
                $photoName = TreatmentSupporter::PATH . '/ts_' . md5(microtime()) . '.' . $this->browsed_photo->extension();
                $ImageFile = Image::make($this->browsed_photo);
                $ImageFile->save($photoName);
                $this->photo = '/' . $photoName;
            } else {
                $this->photo = NULL;
            }
        }

        // if (empty($this->email)) {
        //     $this->email = NULL;
        // }
        $this->organization_id = Auth::user()->org_id;
        $this->phone_number = trim_phone_number($this->phone_number);

        DB::transaction(function () {
            $newSupporter = TreatmentSupporter::create([
                'full_name' => $this->full_name,
                'photo' => $this->photo,
                'email' => $this->email,
                'phone_number' => $this->phone_number,
                'location' => $this->location,
                'district_id' => $this->district_id,
                'organization_id' => $this->organization_id,
            ]);
            // if ($this->state['email'] != NULL) {
            //     $newSupporter->accounts()->create([
            //         'name' => $this->state['full_name'],
            //         'email' => $this->state['email'],
            //         'profile_photo' => $this->state['photo'],
            //         'password' => Hash::make($this->state['phone_number']),
            //         'org_id' => Auth::user()->org_id,
            //     ]);
            // }
            if ($newSupporter) {
                user_log('6', Auth::user()->account_id, 'supporter', $newSupporter->id);
                $this->resetPage();
                $this->dispatchBrowserEvent('hide-supporter-modal', ['message' => 'Supporter added successfully!']);
            }
        });
    }

    public function addSupporter()
    {
        $this->reset(['full_name', 'browsed_photo', 'email', 'phone_number', 'location', 'district_id', 'photo', 'profilePhoto', 'supporterId', 'organization_id']);
        $this->showEditModal = false;
        $this->dispatchBrowserEvent('show-supporter-modal', ['hide_first' => false]);
    }

    public function editSupporter($supporterId)
    {
        $this->reset(['full_name', 'browsed_photo', 'email', 'phone_number', 'location', 'district_id', 'photo', 'profilePhoto', 'supporterId', 'organization_id']);
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

        $this->full_name = $supporter->full_name;
        $this->photo = $supporter->photo;
        $this->email = $supporter->email;
        $this->phone_number = $supporter->phone_number;
        $this->location = $supporter->location;

        // $this->state = $supporter->toArray();
        $this->region_id = $supporter->district->region_id;
        $this->district_id = $supporter->district_id;
        // $this->photo = '';

        $this->dispatchBrowserEvent('show-supporter-modal', ['hide_first' => true]);
        //dd($admin);
    }

    public function updateSupporter()
    {
        // $this->state['user_id'] = $this->userId;
        // dd($this->state);
        $validatedData = $this->validate([
            'full_name' => 'required',
            'email' => 'exclude_if:user_id,null|sometimes|email|unique:users,email,' . $this->userId,
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'location' => 'required',
            'district_id' => 'required',
            'browsed_photo' => 'nullable|image|max:1024',
        ]);

        // dd($validatedData);


        // Validator::make([$this->browsed_photo], [
        //     'photo' => 'mimes:jpeg,jpg,png|max:2000',
        // ])->validate();

        DB::transaction(function () use ($validatedData) {

            if (!empty($validatedData['email'])) {
                $this->email = $validatedData['email'];
            }
            $validatedData['phone_number'] = trim_phone_number($validatedData['phone_number']);
            if ($validatedData['browsed_photo'] != null) {
                if ($this->browsed_photo->isValid()) {
                    $photoName = TreatmentSupporter::PATH . '/ts_' . md5(microtime()) . '.' . $this->browsed_photo->extension();
                    $ImageFile = Image::make($this->browsed_photo);
                    $ImageFile->save($photoName);
                    // $this->editState['profile_photo'] = '/' . $photoName;
                    $validatedData['photo'] = '/' . $photoName;
                }
            }

            $updatedSupporter = TreatmentSupporter::find($this->supporterId);
            $updatedSupporter->update($validatedData);

            // $updatedSupporter->accounts()->update($this->editState);

            if ($updatedSupporter) {
                user_log('7', Auth::user()->account_id, 'supporter', $this->supporterId);
                $this->resetPage();
                $this->dispatchBrowserEvent('hide-supporter-modal', ['message' => 'Supporter updated successfully!']);
            }
        });
    }

    public function viewSupporter($supporterId)
    {

        $this->reset('viewState');
        $supporter = TreatmentSupporter::find($supporterId);
        $this->viewState['id'] = $supporter->id;
        $this->viewState['full_name'] = $supporter->full_name;
        $this->viewState['phone_number'] = $supporter->phone_number;
        $this->viewState['email'] = $supporter->email ?? ' - - - ';
        $this->viewState['location'] = $supporter->location;
        $this->viewState['district'] = $supporter->district->name;
        $this->viewState['region'] = $supporter->district->region->name;
        $this->viewState['total_patients'] = $supporter->patients()->count();
        $this->viewState['patients'] = $supporter->patients;
        $this->dispatchBrowserEvent('show-view-modal');
    }

    public function viewPatient($code = null)
    {
        // dd(route('patients.profile', ['code' => $code]));
        $this->dispatchBrowserEvent('hide-view-modal', ['url' => route('patients.profile', ['code' => $code])]);
    }

    public function deleteModal()
    {
        $this->dispatchBrowserEvent('hide-supporter-modal', ['message' => 'none']);
        $this->dispatchBrowserEvent('show-delete-modal');
    }

    public function deleteSupporter()
    {
        $supporter = TreatmentSupporter::findOrFail($this->supporterId);
        if ($supporter->patients()->count() > 0) {
            $this->dispatchBrowserEvent('show-error-toastr', ['message' => 'UnAssign all Patients relate to this supporter first']);
            $this->dispatchBrowserEvent('hide-delete-modal', ['message' => '']);
        } else {
            $full_name = $this->supporterId . ' - ' . $supporter->full_name;

            $supporter->delete();

            user_log('8', Auth::user()->account_id, 'supporter', $this->supporterId, $full_name);

            $this->dispatchBrowserEvent('hide-delete-modal', ['message' => 'Appointment deleted successfully!']);
        }
    }

    public function updatedsearchTerm()
    {
        $this->resetPage();
    }

    public function searchSupporter()
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
            $this->packageStatus = 4;
        } else {
            $this->packageStatus = $orgSub->status;
        }

        if ($this->searchTerm != null) {
            $supporters = TreatmentSupporter::query()
                ->where('organization_id', Auth::user()->org_id)
                ->where('full_name', 'like', '%' . $this->searchTerm . '%')
                ->latest()->paginate(16);
        } else {
            $supporters = TreatmentSupporter::query()
                ->where('organization_id', Auth::user()->org_id)
                ->latest()->paginate(16);
        }


        if (!empty($this->region_id)) {
            $this->districts = DB::table('districts')
                ->select('id', 'name')
                ->where('region_id', $this->region_id)
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
