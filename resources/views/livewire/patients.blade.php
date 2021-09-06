<div>
    <div class="main-content-wrap">
        <header class="page-header">
            <h1 class="page-title">Patients</h1>
            <form class="app-search d-none d-md-block" wire:submit.prevent="searchPatient">
                <div class="form-group typeahead__container with-suffix-icon mb-0">
                    <div class="typeahead__field">
                        <div class="typeahead__query">
                            <input class="form-control autocomplete-control topbar-search" type="search"
                                placeholder="Type patient's name" wire:model="searchTerm"
                                wire:keydown.enter="searchPatient">
                            <div class="suffix-icon icofont-search"></div>
                        </div>
                    </div>
                </div>
            </form>
        </header>

        <div class="page-content">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr class="bg-primary text-white">
                                    <th scope="col">Photo</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Code</th>
                                    <th scope="col">Age</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Number</th>
                                    <th scope="col" align="center">Last visit</th>
                                    <th scope="col" calss="text-center">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (sizeof($patients)>0)
                                @foreach ($patients as $patient)
                                <tr>
                                    <td>
                                        <img src="{{ $patient->photo == null ? asset('assets/img/default-profile.png') : Storage::disk('profiles')->url($patient->photo) }}"
                                            alt="" width="40" height="40" class="rounded-500">
                                    </td>
                                    <td>
                                        <strong>{{ $patient->first_name }} {{ $patient->first_name }}</strong>
                                    </td>
                                    <td>
                                        <div class="text-muted">{{ $patient->patient_code }}</div>
                                    </td>
                                    <td>
                                        <div class="text-muted text-nowrap">
                                            {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }}</div>
                                    </td>
                                    <td>
                                        <div class="address-col">{{ $patient->location }}</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center nowrap text-primary">
                                            <span class="icofont-ui-cell-phone p-0 mr-2"></span>
                                            {{ $patient->phone_number }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-muted text-nowrap text-center">-</div>
                                    </td>
                                    <td align="center"><span class="badge badge-success">Cleared</span></td>
                                    <td>
                                        <div class="actions">
                                            <a href="{{ route('patient-profile', $patient->id) }}"
                                                class="btn btn-dark btn-sm btn-square rounded-pill">
                                                <span class="btn-icon icofont-external-link"></span>
                                            </a>
                                            <button class="btn btn-info btn-sm btn-square rounded-pill"
                                                wire:click="editPatient({{ $patient->id }})">
                                                <span class="btn-icon icofont-ui-edit"></span>
                                            </button>
                                            <button class="btn btn-error btn-sm btn-square rounded-pill">
                                                <span class="btn-icon icofont-ui-delete"></span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="9" align="center">No Patient Found</td>
                                </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $patients->links() }}
                    </div>
                </div>
            </div>

            @if (Str::contains('prescriber', Auth::user()->account_type) || Auth::user()->account_type ==
            'organization')
            <div class="add-action-box">
                <button class="btn btn-primary btn-lg btn-square rounded-pill" wire:click.prevent="addPatient">
                    <span class="btn-icon icofont-plus"></span>
                </button>
            </div>
            @endif
        </div>
    </div>

    <!-- Add patients modals -->
    <div class="modal fade" id="modal-patient" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @if($showEditModal)
                        <span>Edit Patient</span>
                        @else
                        <span>Add New Patient</span>
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
                                    <input class="form-control @error('first_name') is-invalid @enderror" type="text"
                                        wire:model.defer="state.first_name" id="first_name" name="first_name"
                                        placeholder="First name">
                                    @error('first_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group ">
                                    <input class="form-control @error('last_name') is-invalid @enderror"
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
                                    <select class="form-control @error('gender') is-invalid @enderror" title="Gender"
                                        wire:model.defer="state.gender" id="gender" name="gender">
                                        <option class="d-none">Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
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
                            <input class="form-control @error('phone_number') is-invalid @enderror" type="text"
                                wire:model.defer="state.phone_number" id="phone_number" name="phone_number"
                                placeholder="Phone Number">
                            @error('phone_number')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input class="form-control @error('email') is-invalid @enderror" type="text"
                                wire:model.defer="state.email" id="email" name="email" placeholder="email">
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input class="form-control @error('location') is-invalid @enderror" type="text"
                                placeholder="Patient's Street/Ward" wire:model.defer="state.location" id="location">
                            @error('location')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <select class="form-control @error('region_id') is-invalid @enderror"
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
                            <select class="form-control @error('district_id') is-invalid @enderror"
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
                            <input class="form-control @error('tensel_leader') is-invalid @enderror" type="text"
                                placeholder="tensel leader name" wire:model.defer="state.tensel_leader"
                                id="tensel_leader">
                            @error('tensel_leader')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input class="form-control @error('tensel_leader_phone') is-invalid @enderror" type="text"
                                placeholder="tensel leader phone" wire:model.defer="state.tensel_leader_phone"
                                id="tensel_leader_phone">
                            @error('tensel_leader_phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <select class="form-control" wire:model="state.supporter_id" id="supporter_id"
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
                            <button type="submit" class="btn btn-info">
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
    $(document).ready(function() {
        toastr.options = {
            "positionClass": "toast-bottom-right",
            "progressBar": true,
        }

        window.addEventListener('hide-patient-modal', event => {
            $('#modal-patient').modal('hide');
            toastr.success(event.detail.message, 'Success!');
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
