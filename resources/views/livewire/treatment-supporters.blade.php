<div>
    <div class="main-content-wrap">
        <header class="page-header">
            <h1 class="page-title">Treatment Supporters</h1>
            <form class="app-search d-none d-md-block" wire:submit.prevent="searchPatient">
                <div class="form-group typeahead__container with-suffix-icon mb-0">
                    <div class="typeahead__field">
                        <div class="typeahead__query">
                            <input class="form-control autocomplete-control topbar-search" type="search"
                                placeholder="Type supporter's name" wire:model="searchTerm"
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
                                    <th scope="col">Location</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Patient(s)</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (sizeof($supporters)>0)
                                @foreach ($supporters as $supporter)
                                <tr>
                                    <td>
                                        <img src="{{ $supporter->photo == null ? asset('assets/img/default-profile.png') : Storage::disk('profiles')->url($supporter->photo) }}"
                                            alt="" width="40" height="40" class="rounded-500">
                                    </td>
                                    <td>
                                        <strong>{{ $supporter->full_name }} </strong>
                                    </td>
                                    <td>
                                        <div class="address-col">{{ $supporter->location }}</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center nowrap text-primary">
                                            <span class="icofont-ui-cell-phone p-0 mr-2"></span>
                                            {{ $supporter->phone_number }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-muted text-nowrap">
                                            {{ $supporter->id }}</div>
                                    </td>
                                    <td>
                                        <div class="actions">
                                            <a href="patient.html" class="btn btn-dark btn-sm btn-square rounded-pill">
                                                <span class="btn-icon icofont-external-link"></span>
                                            </a>
                                            <button class="btn btn-info btn-sm btn-square rounded-pill"
                                                wire:click="editSupporter({{ $supporter->id }})">
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
                                    <td colspan="7" align="center">No Treatment Supporter Found</td>
                                </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>

                    {{ $supporters->links() }}
                </div>
            </div>

            <div class="add-action-box">
                <button class="btn btn-primary btn-lg btn-square rounded-pill" wire:click.prevent="addSupporter">
                    <span class="btn-icon icofont-plus"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Add patients modals -->
    <div class="modal fade" id="modal-supporter" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @if($showEditModal)
                        <span>Edit Supporter</span>
                        @else
                        <span>Add New Supporter</span>
                        @endif
                    </h5>
                </div>
                <form autocomplete="off"
                    wire:submit.prevent="{{ $showEditModal ? 'updateSupporter' : 'createSupporter' }}">
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
                        <div class="form-group">
                            <input class="form-control @error('full_name') is-invalid @enderror" type="text"
                                wire:model.defer="state.full_name" id="full_name" name="full_name"
                                placeholder="Full name">
                            @error('full_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
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

        window.addEventListener('hide-supporter-modal', event => {
            $('#modal-supporter').modal('hide');
            toastr.success(event.detail.message, 'Success!');
        })
    });
</script>
<script>
    window.addEventListener('show-supporter-modal', event => {
        $('#modal-supporter').modal('show');
    })

    window.addEventListener('show-delete-modal', event => {
        $('#confirmationModal').modal('show');
    })

    window.addEventListener('hide-delete-modal', event => {
        $('#confirmationModal').modal('hide');
        toastr.success(event.detail.message, 'Success!');
    })

        // window.addEventListener('hide-supporter-modal', event => {
        //     $('#add-admin').modal('hide');
        // })
</script>
@endpush
