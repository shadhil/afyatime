<div>
    <h2 class="content-heading">Treatment Supporters</h2>
    @if (Auth::user()->isAdmin())
    <div class="block-header">
        {{-- <h3 class="block-title"></h3> --}}
        {{-- <div class="block-title"> --}}
            @if (is_subscribed())
            <button type="button" class="btn btn-alt-primary" wire:click="addSupporter">
                <i class="fa fa-plus mr-5"></i>New Supporter
            </button>
            @endif

            <div class="form-group row">
                <div class="col-md-12">
                    <div class="form-material form-material-primary">
                        <input type="text" class="form-control" wire:model="searchTerm"
                            wire:keydown.enter="searchSupporter" name="searchTerm" placeholder="Search Supporter"
                            wire:keydown.enter="searchSupporter">
                    </div>
                </div>
            </div>
            {{--
        </div> --}}
    </div>
    @endif
    @if (sizeof($supporters)>0)
    <div class="row">
        @foreach ($supporters as $supporter)
        <div class="col-md-4 col-xl-3">
            <a class="block block-link-shadow" href="javascript:void(0)"
                wire:click.prevent="viewSupporter({{ $supporter->id }})">
                <div class="block-content block-content-full clearfix">
                    <div class="float-right">
                        <img class="img-avatar"
                            src="{{ $supporter->photo == null ? asset('assets/img/default-profile.png') : Storage::disk('profiles')->url($supporter->photo) }}"
                            alt="">
                    </div>
                    <div class="float-left mt-10">
                        <div class="font-w600 mb-5">{{ $supporter->full_name }}</div>
                        <div class="font-size-sm text-muted">{{ $supporter->patients()->count() }} Patient(s)</div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    <div class="float-right mb-15">
        {{ $supporters->links('vendor.livewire.bootstrap') }}
    </div>
    @else
    <div class="row mb-15">
        <div class="col-sm-12 col-xl-12 text-center">
            No Supporter Found
        </div>
    </div>
    @endif

    <div class="modal fade" id="modal-supporter" tabindex="-1" role="dialog" aria-labelledby="modal-popout"
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
                        <form wire:submit.prevent="{{ $showEditModal ? 'updateSupporter' : 'createSupporter' }}">
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
                                <div class="col-12">
                                    <label for="full_name">Firstname</label>
                                    <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                                        wire:model.defer="state.full_name" id="full_name" name="full_name"
                                        placeholder="Enter your full name..">
                                    @error('full_name')
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
                    @if ($showEditModal)
                    <button type="button" class="btn btn-alt-danger" wire:click="deleteModal()">
                        <i class="fa fa-trash"></i> Delete
                    </button>
                    @endif
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="view-modal" tabindex="-1" role="dialog" aria-labelledby="modal-slideup"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-slideup" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Supporter's Details</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <table class="table table-striped table-borderless mt-20">
                            <tbody>
                                <tr>
                                    <td class="font-w600">Full Name</td>
                                    <td>{{ $viewState['full_name'] ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-w600">Phone Number</td>
                                    <td>{{ $viewState['phone_number'] ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-w600">Email</td>
                                    <td>{{ $viewState['email'] ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-w600">Location</td>
                                    <td>
                                        {{ $viewState['location'] ?? '' }} - {{ $viewState['district'] ?? '' }}, {{
                                        $viewState['region'] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-w600">Patients</td>
                                    <td>
                                        @foreach ($viewState['patients'] ?? [] as $patient)
                                        <a
                                            href="{{ route('patients.profile', ['code' => $patient->patient_code ?? '0']) }}">{{
                                            $patient->first_name ?? '' }} {{ $patient->last_name ?? ''
                                            }}</a> <br>
                                        @endforeach
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    @if (is_subscribed())
                    @if (Auth::user()->isAdmin())
                    <button type="button" class="btn btn-alt-info"
                        wire:click="editSupporter({{ $viewState['id'] ?? '0' }})">
                        <i class="fa fa-edit"></i> Edit Appointment
                    </button>
                    @endif
                    @endif
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="modal-slideup"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-slideup" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Delete Supporter</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <h5>Are you sure you want to delete this treatment supporter?, because all the patient
                            associated with him/her will be without one.</h5>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-alt-danger" wire:click.prevent="deleteSupporter">
                        <i class="fa fa-trash"></i> Confirm Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    $(document).ready(function() {
        toastr.options = {
            "positionClass": "toast-bottom-right",
            "progressBar": true,
        }

        window.addEventListener('hide-supporter-modal', event => {
            $('#modal-supporter').modal('hide');
            if(event.detail.message != 'none'){
                toastr.success(event.detail.message, 'Success!');
            }
        })
    });
</script>
<script>
    window.addEventListener('show-supporter-modal', event => {
        // alert(event.detail.hide_first);
        if (event.detail.hide_first == true ) {
            $('#view-modal').modal('hide');
            setTimeout(function(){ $('#modal-supporter').modal('show'); }, 1000);
        }else{
            $('#modal-supporter').modal('show');
        }

    })

    window.addEventListener('show-delete-modal', event => {
        $('#delete-modal').modal('show');
    })

    window.addEventListener('hide-delete-modal', event => {
        $('#delete-modal').modal('hide');
        toastr.success(event.detail.message, 'Success!');
    })

    window.addEventListener('show-view-modal', event => {
        $('#view-modal').modal('show');
    })

    window.addEventListener('hide-view-modal', event => {
        $('#view-modal').modal('hide');
        // window.location.href = event.detail.url;
        // toastr.success(event.detail.message, 'Success!');
    })

    window.addEventListener('show-error-toastr', event => {
        toastr.error(event.detail.message, 'Error!');
    })

        // window.addEventListener('hide-supporter-modal', event => {
        //     $('#add-admin').modal('hide');
        // })
</script>
@endpush
