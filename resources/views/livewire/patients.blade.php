<div>
    <h2 class="content-heading">Patients</h2>
    @if (Auth::user()->isAdmin())
    <div class="block-header">
        {{-- <h3 class="block-title"></h3> --}}
        {{-- <div class="block-title"> --}}
            <button type="button" class="btn btn-alt-primary" wire:click="addPatient">
                <i class="fa fa-plus mr-5"></i>New Patient
            </button>

            <div class="form-group row">
                <div class="col-md-12">
                    <div class="form-material form-material-primary">
                        <input type="text" class="form-control" wire:model="searchTerm"
                            wire:keydown.enter="searchPatient" name="searchPatient" placeholder="Search Patient"
                            wire:keydown.enter="searchPatient">
                    </div>
                </div>
            </div>
            {{--
        </div> --}}
    </div>
    @endif
    @if (sizeof($patients)>0)
    <div class="row">
        @foreach ($patients as $patient)
        @if ($patient->lastAppointment->date_of_visit ?? '' >= now())
        <div class="col-md-4 col-xl-3">
            <a class="block text-center" href="{{ route('patients.profile', ['code' => $patient->patient_code]) }}">
                <div class="block-content block-content-full bg-gd-dusk">
                    <img class="img-avatar img-avatar-thumb"
                        src="{{ $patient->photo == null ? asset('assets/base/media/avatars/avatar.jpg') : Storage::disk('profiles')->url($patient->photo) }}"
                        alt="">
                </div>
                <div class="block-content block-content-full">
                    <div class="font-w600 mb-5">{{ $patient->first_name }} {{ $patient->last_name }}</div>
                    <div class="font-size-sm text-muted">#{{ $patient->patient_code }}</div>
                </div>
            </a>
        </div>
        @else
        <div class="col-md-4 col-xl-3">
            <a class="block block-link-pop text-center"
                href="{{ route('patients.profile', ['code' => $patient->patient_code]) }}">
                <div class="block-content block-content-full">
                    <img class="img-avatar"
                        src="{{ $patient->photo == null ? asset('assets/base/media/avatars/avatar.jpg') : Storage::disk('profiles')->url($patient->photo) }}"
                        alt="">
                </div>
                <div class="block-content block-content-full bg-body-light">
                    <div class="font-w600 mb-5">{{ $patient->first_name }} {{ $patient->last_name }}</div>
                    <div class="font-size-sm text-muted">#{{ $patient->patient_code }}</div>
                </div>
            </a>
        </div>
        @endif
        @endforeach
    </div>
    <div class="float-right mb-15">
        {{ $patients->links('vendor.livewire.bootstrap') }}
    </div>
    @else
    <div class="row mb-15">
        <div class="col-sm-12 col-xl-12 text-center">
            No Patient Found
        </div>
    </div>
    @endif

    <div class="modal fade" id="modal-patient" tabindex="-1" role="dialog" aria-labelledby="modal-popout"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-popout" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">
                            @if($showEditModal)
                            <span>Edit Patient</span>
                            @else
                            <span>Add Patient</span>
                            @endif
                        </h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <form wire:submit.prevent="{{ $showEditModal ? 'updatePatient' : 'createPatient' }}">
                            <div class="form-group row">
                                <div class="col-12 col-sm-12 text-center">
                                    <div class="form-group avatar-box">
                                        <div class="img-box" onclick="document.getElementById('photo').click();"
                                            style="cursor: pointer">
                                            @if ($photo)
                                            <img src="{{ $photo->temporaryUrl() }}" width="150" height="150" alt="">
                                            @else
                                            <img src="{{ $profilePhoto == null ? asset('assets/img/default-profile.png') : Storage::disk('profiles')->url($profilePhoto) }}"
                                                width="150" height="150" alt="">
                                            @endif
                                        </div>
                                    </div>
                                    {{-- <button class="btn btn-outline-primary self-center" type="button"
                                        id="browseImg" type="button"
                                        onclick="document.getElementById('photo').click();">
                                        Browse Image
                                    </button> --}}
                                    <input wire:model="photo" type="file" accept="image/*" style="display:none;"
                                        id="photo" name="photo">
                                    @if ($photo)
                                    {{ $photo->getClientOriginalName() }}
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="firstname">Firstname</label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                        wire:model.defer="state.first_name" id="first_name" name="first_name"
                                        placeholder="Enter your firstname..">
                                    @error('first_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label for="lastname">Lastname</label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                        wire:model.defer="state.last_name" id="last_name" name="last_name"
                                        placeholder="Enter your lastname..">
                                    @error('last_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="date_of_birth">Date of Birth</label>
                                    <input type="text"
                                        class="js-flatpickr form-control bg-white @error('date_of_birth') is-invalid @enderror"
                                        wire:model.defer="state.date_of_birth" id="date_of_birth" name="date_of_birth"
                                        placeholder="d-m-Y" data-date-format="d-m-Y">
                                    @error('date_of_birth')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label for="gender">Gender</label>
                                    <select class="form-control @error('gender') is-invalid @enderror" title="Gender"
                                        wire:model.defer="state.gender" id="gender" name="gender" size="1">
                                        <option value="" class="d-none">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                    @error('gender')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12" for="phone_number">Phone Number</label>
                                <div class="col-12">
                                    <div class="input-group">
                                        <input type="text"
                                            class="form-control @error('phone_number') is-invalid @enderror"
                                            wire:model.defer="state.phone_number" id="phone_number" name="phone_number"
                                            placeholder="Enter your phone number..">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fa fa-phone"></i>
                                            </span>
                                        </div>
                                        @error('phone_number')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12" for="email">Email</label>
                                <div class="col-12">
                                    <div class="input-group">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            wire:model.defer="state.email" id="email" name="email"
                                            placeholder="Enter your email..">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fa fa-envelope-o"></i>
                                            </span>
                                        </div>
                                        @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12" for="location">Location</label>
                                <div class="col-12">
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('location') is-invalid @enderror"
                                            wire:model.defer="state.location" id="location" name="location"
                                            placeholder="Enter your location..">
                                        @error('location')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                        {{-- <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fa fa-location"></i>
                                            </span>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="region_id">Region</label>
                                    <select class="form-control @error('region_id') is-invalid @enderror"
                                        title="Region Name" wire:model="state.region_id" id="region_id" name="region_id"
                                        size="1">
                                        <option value="" class="d-none">Select Region</option>
                                        @foreach ($regions as $region)
                                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('region_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label for="district_id">District</label>
                                    <select class="form-control @error('district_id') is-invalid @enderror"
                                        title="District Name" wire:model.defer="state.district_id" id="district_id"
                                        name="district_id" size="1">
                                        <option value="" class="d-none">Select District</option>
                                        @foreach ($districts as $district)
                                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('district_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            @if (Auth::user()->isAdmin())
                            <div class="form-group row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-alt-info" wire:loading.attr="disabled">
                                        <i class="fa fa-send mr-5"></i>
                                        @if($showEditModal)
                                        Save Changes
                                        @else
                                        Save
                                        @endif
                                    </button>
                                </div>
                            </div>
                            @endif
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add patients modals -->
    <div class="modal fade" id="modal-patient-0" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @if($showEditModal)
                        <span>Edit Patient</span>
                        @else
                        <span> New Patient</span>
                        @endif
                    </h5>
                </div>
                <form autocomplete="off" wire:submit.prevent="{{ $showEditModal ? 'updatePatient' : 'createPatient' }}">
                    <div class="modal-body">
                        <div class="form-group avatar-box d-flex align-items-center">
                            @if ($photo)
                            <img src="{{ $photo->temporaryUrl() }}" width="100" height="100" alt=""
                                class="rounded-500 mr-4">
                            @else
                            <img src="{{ $profilePhoto == null ? asset('assets/img/default-profile.png') : Storage::disk('profiles')->url($profilePhoto) }}"
                                width="100" height="100" alt="" class="rounded-500 mr-4">
                            @endif

                            <button class="btn btn-outline-primary" type="button"
                                onclick="document.getElementById('photo').click();">
                                Change photo
                            </button>
                            <input wire:model="photo" type="file" accept="image/*" style="display:none;" id="photo"
                                name="photo">
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <input class="form-control rounded @error('first_name') is-invalid @enderror"
                                        type="text" wire:model.defer="state.first_name" id="first_name"
                                        name="first_name" placeholder="First name">
                                    @error('first_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group ">
                                    <input class="form-control rounded @error('last_name') is-invalid @enderror"
                                        wire:model.defer="state.last_name" id="last_name" name="last_name" type="text"
                                        placeholder="Last name">
                                    @error('last_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <x-datepicker wire:model.defer="state.date_of_birth" id="date_of_birth"
                                        :error="'date_of_birth'" :holder="'date of birth'" />
                                    @error('date_of_birth')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <select class="form-control rounded @error('gender') is-invalid @enderror"
                                        title="Gender" wire:model.defer="state.gender" id="gender" name="gender">
                                        <option class="d-none">Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                    @error('gender')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <input class="form-control rounded @error('phone_number') is-invalid @enderror" type="text"
                                wire:model.defer="state.phone_number" id="phone_number" name="phone_number"
                                placeholder="Phone Number">
                            @error('phone_number')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input class="form-control rounded @error('email') is-invalid @enderror" type="text"
                                wire:model.defer="state.email" id="email" name="email" placeholder="email">
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input class="form-control rounded @error('location') is-invalid @enderror" type="text"
                                placeholder="Patient's Street/Ward" wire:model.defer="state.location" id="location">
                            @error('location')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <select class="form-control rounded @error('region_id') is-invalid @enderror"
                                wire:model="state.region_id" id="region_id" name="region_id">
                                <option value="">Select Region</option>
                                @foreach ($regions as $region)
                                <option value="{{ $region->id }}">{{ $region->name }}</option>
                                @endforeach
                            </select>
                            @error('region_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <select class="form-control rounded @error('district_id') is-invalid @enderror"
                                wire:model.defer="state.district_id" id="district_id" name="district_id">
                                <option value="">Select District</option>
                                @foreach ($districts as $district)
                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                                @endforeach
                            </select>
                            @error('district_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input class="form-control rounded @error('tensel_leader') is-invalid @enderror" type="text"
                                placeholder="tensel leader name" wire:model.defer="state.tensel_leader"
                                id="tensel_leader">
                            @error('tensel_leader')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input class="form-control rounded @error('tensel_leader_phone') is-invalid @enderror"
                                type="text" placeholder="tensel leader phone"
                                wire:model.defer="state.tensel_leader_phone" id="tensel_leader_phone">
                            @error('tensel_leader_phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <select class="form-control rounded" wire:model="state.supporter_id" id="supporter_id"
                                name="supporter_id">
                                <option class="d-none">Select Supporter</option>
                                @foreach ($supporters as $supporter)
                                <option value="{{ $supporter->id }}">{{ $supporter->full_name }} <small>
                                        ({{ $supporter->phone_number }}) </small> </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer d-block">
                        <div class="actions justify-content-between">
                            <button type="button" class="btn btn-error" data-dismiss="modal">Cancel</button>

                            <button type="button" class="btn btn-info btn-load" wire:loading
                                wire:target="{{ $showEditModal ? 'updatePatient' : 'createPatient' }}">
                                <span class="btn-loader icofont-spinner"></span>
                            </button>

                            <button type="submit" class="btn btn-info" wire:loading.attr="hidden">
                                @if($showEditModal)
                                <span>Save Changes</span>
                                @else
                                <span>Save</span>
                                @endif
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end Add patients modals -->
</div>

@push('scripts')
<script>
    jQuery(function(){Codebase.helpers(['flatpickr', 'datepicker']);});
</script>
<script>
    $(document).ready(function() {
        toastr.options = {
            "positionClass": "toast-bottom-right",
            "progressBar": true,
        }

        window.addEventListener('hide-patient-modal', event => {
            $('#modal-patient').modal('hide');
            toastr.success(event.detail.message, 'Success!');
            window.location.href = event.detail.url;
        })
    });
</script>
<script>
    window.addEventListener('show-patient-modal', event => {
        $('#modal-patient').modal('show');
    })

    window.addEventListener('show-delete-modal', event => {
        $('#confirmationModal').modal('show');
    })

    window.addEventListener('hide-delete-modal', event => {
        $('#confirmationModal').modal('hide');
        toastr.success(event.detail.message, 'Success!');
    })

        // window.addEventListener('hide-patient-modal', event => {
        //     $('#add-admin').modal('hide');
        // })
</script>
@endpush
