<div>
    <!-- Header -->
    <div class="bg-white">
        <div class="content content-full">
            <div class="pt-50 pb-30 text-center">
                <h1 class="font-w300 mb-10">Dashboard</h1>
                <h2 class="h4 text-muted font-w300 mb-0">Welcome <strong>{{ Str::before(Auth::user()->name, ' ')
                        }}</strong>, everything
                    looks good.</h2>
            </div>
        </div>
    </div>
    <!-- END Header -->
    <!-- Page Content -->
    <div class="content">
        <!-- Mini Stats -->
        <div class="row">
            <div class="col-6 col-xl-3">
                <a class="block block-rounded" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="py-20 text-center">
                            <div class="font-size-h2 font-w700 mb-0 text-primary-dark">869</div>
                            <div class="font-size-sm font-w600 text-primary-light">Sales</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-xl-3">
                <a class="block block-rounded" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="py-20 text-center">
                            <div class="font-size-h2 font-w700 mb-0 text-primary-dark">$1,360</div>
                            <div class="font-size-sm font-w600 text-primary-light">Earnings</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-xl-3">
                <a class="block block-rounded" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="py-20 text-center">
                            <div class="font-size-h2 font-w700 mb-0 text-primary-dark">$15,500</div>
                            <div class="font-size-sm font-w600 text-primary-light">Total</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-xl-3">
                <a class="block block-rounded" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="py-20 text-center">
                            <div class="font-size-h2 font-w700 mb-0 text-primary-dark">$19,600</div>
                            <div class="font-size-sm font-w600 text-primary-light">Estimated</div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- END Mini Stats -->

        <div class="block">
            <div class="block-header block-header-default">
                {{-- <h3 class="block-title">All Organizations</h3> --}}
                <button type="button" class="btn btn-alt-primary" wire:click="addOrg">
                    <i class="fa fa-plus mr-5"></i>New Organization
                </button>

                <div class="form-group row">
                    <div class="col-md-12">
                        <div class="form-material form-material-primary">
                            <input type="text" class="form-control" wire:model="searchTerm"
                                wire:keydown.enter="searchOrganization" name="searchOrganization"
                                placeholder="Search Organization" wire:keydown.enter="searchOrganization">
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-content">

                <table class="table table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 100px;"><i class="si si-home"></i></th>
                            <th width="30%"> Name</th>
                            <th class="d-none d-sm-table-cell" width="15%">Location</th>
                            <th class="d-none d-md-table-cell text-center">Patients</th>
                            <th class="d-none d-md-table-cell text-center">Prescribers</th>
                            <th class="d-none d-md-table-cell" width="15%">Due Date</th>
                            <th class="d-none d-md-table-cell text-center">Status</th>
                            <th class="text-center" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (sizeof($organizations)>0)
                        @foreach ($organizations as $org)
                        <tr>
                            <td class="text-center">
                                <img class="img-avatar img-avatar48"
                                    src="{{ $org->logo == null ? asset('assets/img/default-profile.png') : Storage::disk('profiles')->url($org->logo) }}"
                                    alt="">
                            </td>
                            <td class="font-w700" width="30%">
                                <a href="{{ route('admin.organizations.profile', $org->id) }}">
                                    {{ $org->name }}
                                </a>
                            </td>
                            <td class="d-none d-sm-table-cell" style="width: 15%;">
                                {{ $org->district->name }}, {{ $org->district->region->name }}
                            </td>
                            <td class="d-none d-md-table-cell text-center">
                                <span class="font-size-h5 font-italic"> {{ $org->patients()->count() }} </span>
                            </td>
                            <td class="d-none d-md-table-cell text-center">
                                <span class="font-size-h5 font-italic"> {{ $org->prescribers()->count() }} </span>
                            </td>
                            <td class="d-none d-md-table-cell" width="15%">
                                {{ $org->subscriptions()->latest()->first() == null ? '- - -' :
                                \Carbon\Carbon::parse($org->latestSubscription->end_date)->format('M j,
                                Y') }}
                            </td>
                            <td class="d-none d-md-table-cell text-center">
                                <span class="badge @switch($org->latestSubscription->status ?? '')
                                        @case('1')
                                        badge-warning
                                            @break
                                        @case('2')
                                        badge-primary
                                            @break
                                        @case('3')
                                        badge-info
                                        @break
                                        @case('4')
                                        badge-info
                                        @break
                                        @case('5')
                                        badge-danger
                                        @break
                                        @default
                                        badge-secondary
                                    @endswitch
                                    ">
                                    {{ ($org->latestSubscription->status ?? '-') == '-' ? 'Registered' :
                                    $org->latestSubscription->shortStatus() }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip"
                                            title="Visited" wire:click="editOrg({{ $org->id }})">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </div>
                                    <a href="{{ route('admin.organizations.profile', $org->id) }}" type="button"
                                        class="btn btn-sm btn-primary" data-toggle="tooltip" title="View">
                                        <i class=" fa fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="float-right">
            {{ $organizations->links('vendor.livewire.bootstrap') }}
        </div>

        <div class="modal fade" id="add-organization" tabindex="-1" role="dialog" aria-labelledby="modal-popout"
            aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-dialog-popout" role="document">
                <div class="modal-content">
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title">
                                @if($showEditModal)
                                <span>Edit Organization</span>
                                @else
                                <span>Add Organization</span>
                                @endif
                            </h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="si si-close"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <form wire:submit.prevent="{{ $showEditModal ? 'updateOrg' : 'createOrg' }}">
                                <div class="form-group row">
                                    <div class="col-12 col-sm-12 text-center">
                                        <div class="form-group avatar-box">
                                            <div class="img-box" onclick="document.getElementById('logo').click();"
                                                style="cursor: pointer">
                                                @if ($logo)
                                                <img src="{{ $logo->temporaryUrl() }}" width="150" height="150" alt="">
                                                @else
                                                <img src="{{ $orgLogo == null ? asset('assets/img/default-profile.png') : Storage::disk('profiles')->url($orgLogo) }}"
                                                    width="150" height="150" alt="">
                                                @endif
                                            </div>
                                        </div>
                                        {{-- <button class="btn btn-outline-primary self-center" type="button"
                                            id="browseImg" type="button"
                                            onclick="document.getElementById('logo').click();">
                                            Browse Image
                                        </button> --}}
                                        <input wire:model="logo" type="file" accept="image/*" style="display:none;"
                                            id="logo" name="logo">
                                        @if ($logo)
                                        {{ $logo->getClientOriginalName() }}
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            wire:model.defer="state.name" id="name" name="name"
                                            placeholder="Enter organization's name..">
                                        @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12">
                                        <label for="organization_type">Organization Type</label>
                                        <select class="form-control @error('organization_type') is-invalid @enderror"
                                            title="organization_type" wire:model.defer="state.organization_type"
                                            id="organization_type" name="organization_type" size="1">
                                            <option value="" class="d-none">Select type</option>
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
                                </div>
                                <div class="form-group row">
                                    <label class="col-12" for="phone_number">Phone Number</label>
                                    <div class="col-12">
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control @error('phone_number') is-invalid @enderror"
                                                wire:model.defer="state.phone_number" id="phone_number"
                                                name="phone_number" placeholder="Enter your phone number..">
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
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror"
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
                                            <input type="text"
                                                class="form-control @error('location') is-invalid @enderror"
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
                                            title="Region Name" wire:model="state.region_id" id="region_id"
                                            name="region_id" size="1">
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
                                @if($showEditModal)
                                <div class="form-group row">
                                    <label class="col-12" for="location">Password</label>
                                    <div class="col-12">
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control @error('password') is-invalid @enderror"
                                                wire:model.defer="state.password" id="password" name="password"
                                                placeholder="Enter your password..">
                                            @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12" for="location">Confirm Password</label>
                                    <div class="col-12">
                                        <div class="input-group">
                                            <input type="password"
                                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                                wire:model.defer="state.password_confirmation" id="passwordConfirmation"
                                                name="password_confirmation" placeholder="Enter your location..">
                                            @error('password_confirmation')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input class="form-control rounded @error('password') is-invalid @enderror"
                                        type="password" placeholder="password" wire:model.defer="state.password"
                                        id="password">
                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input class="form-control rounded" type="password" placeholder="confirm password"
                                        wire:model.defer="state.password_confirmation" id="passwordConfirmation">
                                </div>
                                @endif
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
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="add-organization-0" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
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
                                <input class="form-control rounded flatpickr-input @error('name') is-invalid @enderror"
                                    type="text" placeholder="Name" wire:model.defer="state.name" id="name" required>
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <select class="form-control rounded @error('organization_type') is-invalid @enderror"
                                    wire:model.defer="state.organization_type" id="organization_type"
                                    name="organization_type">
                                    <option class="d-none">Organization Type</option>
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
                                <input class="form-control rounded @error('known_as') is-invalid @enderror" type="text"
                                    placeholder="Comon Nama (a.k.a)" wire:model.defer="state.known_as" id="known_as">
                                @error('known_as')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input class="form-control rounded @error('email') is-invalid @enderror" type="email"
                                    placeholder="email" wire:model.defer="state.email" id="email">
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input class="form-control rounded @error('phone_number') is-invalid @enderror"
                                    type="text" placeholder="phone number" wire:model.defer="state.phone_number"
                                    id="phoneNumber">
                                @error('phone_number')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input class="form-control rounded @error('location') is-invalid @enderror" type="text"
                                    placeholder="Organization Location" wire:model.defer="state.location" id="location">
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
                            @if($showEditModal)
                            <div class="form-group">
                                <input class="form-control rounded @error('password') is-invalid @enderror"
                                    type="password" placeholder="password" wire:model.defer="state.password"
                                    id="password">
                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input class="form-control rounded" type="password" placeholder="confirm password"
                                    wire:model.defer="state.password_confirmation" id="passwordConfirmation">
                            </div>
                            @endif
                        </div>
                        <div class="modal-footer d-block">
                            <div class="actions justify-content-between">
                                <button type="button" class="btn btn-error" data-dismiss="modal">Cancel</button>

                                <button type="button" class="btn btn-info btn-load" wire:loading
                                    wire:target="{{ $showEditModal ? 'updateOrg' : 'createOrg' }}">
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
