<div>
    <div class="main-content-wrap">
        <header class="page-header">
            <h1 class="page-title">Organizations</h1>
        </header>

        <div class="page-content">
            <div class="row">
                @if (sizeof($organizations)>0)
                @foreach ($organizations as $org)
                <div class="col-12 col-md-4">
                    <div class="card text-center mb-md-0 bg-light">
                        <div class="card-header">
                            {{ $org->name }}
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="fs-48 mr-2">Jul 3</div>
                                <div class="text-muted">
                                    <div class="fs-20">DUE</div>
                                    <div>date</div>
                                </div>
                            </div>

                            <hr class="mt-4 mb-4">

                            <ul class="list-unstyled text-left">
                                <li class="d-flex align-items-center pt-2 pb-2">
                                    <div class="icon icofont-check-circled text-muted"></div>
                                    <span class="ml-1">{{ $org->patients ?? '0' }} Total Patients</span>
                                </li>
                                <li class="d-flex align-items-center pt-2 pb-2">
                                    <div class="icon icofont-check-circled text-muted"></div>
                                    <span class="ml-1">{{ $org->prescribers ?? '0' }} Total Prescribers</span>
                                </li>
                                <li class="d-flex align-items-center pt-2 pb-2">
                                    <div class="icon icofont-check-circled text-muted"></div>
                                    <span class="ml-1">{{ $org->supporters ?? '0' }} Total Supporters</span>
                                </li>
                                <li class="d-flex align-items-center pt-2 pb-2">
                                    <div class="icon icofont-check-circled text-muted"></div>
                                    <span class="ml-1">{{ $org->appointments ?? '0' }} Total Appointments</span>
                                </li>
                                <li class="d-flex align-items-center pt-2 pb-2">
                                    <div class="icon icofont-location-pin text-muted"></div>
                                    <span class="ml-1">{{ $org->district }}, {{ $org->region }}</span>
                                </li>
                            </ul>

                            <a href="{{ route('admin.organizations.profile', $org->id) }}"
                                class="btn btn-primary btn-block mb-3">View Profile</a>
                        </div>
                    </div>
                </div>
                @endforeach

                @else

                @endif
            </div>
            <div class="add-action-box">
                <button class="btn btn-primary btn-lg btn-square rounded-pill" wire:click.prevent="addOrg">
                    <span class="btn-icon icofont-plus"></span>
                </button>
            </div>
        </div>
    </div>


    <div class="modal fade" id="add-organization" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @if($showEditModal)
                        <span>Edit Organization</span>
                        @else
                        <span> New Organization</span>
                        @endif
                    </h5>
                </div>
                <form autocomplete="off" wire:submit.prevent="{{ $showEditModal ? 'updateOrg' : 'createOrg' }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <input class="form-control flatpickr-input @error('name') is-invalid @enderror" type="text"
                                placeholder="Name" wire:model.defer="state.name" id="name" required>
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <select class="form-control @error('organization_type') is-invalid @enderror"
                                wire:model.defer="state.organization_type" id="organization_type"
                                name="organization_type">
                                <option value="">Organization Type</option>
                                @foreach ($orgTypes as $orgType)
                                <option value="{{ $orgType->id }}">{{ $orgType->type }}</option>
                                @endforeach
                            </select>
                            @error('organization_type')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input class="form-control @error('email') is-invalid @enderror" type="email"
                                placeholder="email" wire:model.defer="state.email" id="email">
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input class="form-control @error('phone_number') is-invalid @enderror" type="text"
                                placeholder="phone number" wire:model.defer="state.phone_number" id="phoneNumber">
                            @error('phone_number')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input class="form-control @error('location') is-invalid @enderror" type="text"
                                placeholder="Organization Location" wire:model.defer="state.location" id="location">
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
                            <input class="form-control @error('password') is-invalid @enderror" type="password"
                                placeholder="password" wire:model.defer="state.password" id="password">
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input class="form-control" type="password" placeholder="confirm password"
                                wire:model.defer="state.password_confirmation" id="passwordConfirmation">
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

    <!-- Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Delete Organization</h5>
                </div>

                <div class="modal-body">
                    <h4>Are you sure you want to delete this organization?</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                            class="fa fa-times mr-1"></i>
                        Cancel</button>
                    <button type="button" wire:click.prevent="deleteOrg" class="btn btn-danger"><i
                            class="fa fa-trash mr-1"></i>Delete Organization</button>
                </div>
            </div>
        </div>
    </div>
</div>


@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/icofont.min.css') }}">
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        toastr.options = {
            "positionClass": "toast-bottom-right",
            "progressBar": true,
        }

        window.addEventListener('hide-org-modal', event => {
            $('#add-organization').modal('hide');
            toastr.success(event.detail.message, 'Success!');
        })

        $('#datetimepicker3').datetimepicker({
            format: 'LT',
        });
    });
</script>
<script>
    window.addEventListener('show-org-modal', event => {
            $('#add-organization').modal('show');
        })

        window.addEventListener('show-delete-modal', event => {
            $('#confirmationModal').modal('show');
        })

        window.addEventListener('hide-delete-modal', event => {
            $('#confirmationModal').modal('hide');
            toastr.success(event.detail.message, 'Success!');
        })

        // window.addEventListener('hide-org-modal', event => {
        //     $('#add-organization').modal('hide');
        // })
</script>

<script>
    // $('#organization_type').selectpicker({
    //     style: '',
    //     styleBase: 'form-control',
    //     tickIcon: 'icofont-check-alt'
    // });

    // $('#region_id').selectpicker({
    //     style: '',
    //     styleBase: 'form-control',
    //     tickIcon: 'icofont-check-alt'
    // });

    // $('#district_id').selectpicker({
    //     style: '',
    //     styleBase: 'form-control',
    //     tickIcon: 'icofont-check-alt'
    // });
    // console.log('init select');


    // window.livewire.on('setRegionId', id => {
    //     $('#region_id').selectpicker('val', id);
    //     console.log('set reg-id');
    // });

    //  window.livewire.on('setDistrictId', id => {
    //     $('#district_id').selectpicker('val', id);
    //     console.log('set dist-id');
    // });

    //  window.livewire.on('setOrgId', id => {
    //     $('#organization_type').selectpicker('val', id);
    // });
</script>
@endpush
</div>
