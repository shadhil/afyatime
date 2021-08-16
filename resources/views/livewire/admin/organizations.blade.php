<div>
    <div class="main-content-wrap">
        <header class="page-header">
            <h1 class="page-title">Organization</h1>
        </header>

        <div class="page-content">

            <div class="card mb-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Prescribers</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (sizeof($organizations)>0)
                                @foreach ($organizations as $org)
                                <tr>
                                    <td>
                                        <div class="text-muted text-nowrap">{{ $org->name }}</div>
                                    </td>
                                    <td><strong>{{ $org->email }}</strong></td>
                                    <td>
                                        <div class="text-nowrap text-success">
                                            <i class="icofont-check-circled"></i> {{ $org->phone_number }}
                                        </div>
                                    </td>
                                    <td><strong>{{ $org->account_type }}.</strong></td>
                                    <td>
                                        <div class="actions">
                                            <a href="patient.html" class="btn btn-dark btn-sm btn-square rounded-pill">
                                                <span class="btn-icon icofont-external-link"></span>
                                            </a>
                                            <button class="btn btn-info btn-sm btn-square rounded-pill"
                                                wire:click.prevent="editOrg({{ $org->id }})">
                                                <span class="btn-icon icofont-ui-edit"></span>
                                            </button>
                                            <button class="btn btn-error btn-sm btn-square rounded-pill"
                                                wire:click.prevent="confirmOrgRemoval({{ $org->id }})">
                                                <span class="btn-icon icofont-ui-delete"></span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="5" align="center"> No Organization Found!</td>
                                </tr>

                                @endif


                            </tbody>
                        </table>
                    </div>
                    <br />
                    {{ $organizations->links() }}


                </div>
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
@endpush
</div>
