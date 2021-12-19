<div>
    <h2 class="content-heading">Prescribers</h2>
    @if (Auth::user()->isAdmin())
    <div class="block-header">
        {{-- <h3 class="block-title"></h3> --}}
        {{-- <div class="block-title"> --}}
            @if (is_subscribed() && Auth::user()->isAdmin())
            <button type="button" class="btn btn-alt-primary" wire:click="addPrescriber">
                <i class="fa fa-plus mr-5"></i>New Prescriber
            </button>
            @if (Auth::user()->account_type == 'organization')
            <button type="button" class="btn btn-alt-warning" wire:click="showTitleModal">
                <i class="fa fa-plus mr-5"></i>New Role/Title
            </button>
            @endif
            @endif
            {{--
        </div> --}}
    </div>
    @endif
    <div class="row">
        <!-- Row #1 -->
        @if (sizeof($prescribers)>0)
        @foreach ($prescribers as $prescriber)
        <div class="col-md-4 col-xl-3">
            <div class="block text-center">
                <div class="block-content block-content-full block-sticky-options pt-30">
                    <div class="block-options">
                        @if (Auth::user()->isAdmin())
                        <div class="dropdown">
                            <button type="button" class="btn-block-option"
                                wire:click.prevent="editPrescriber({{ $prescriber->id }})" aria-expanded="false">
                                <i class="fa fa-edit"></i>
                            </button>
                        </div>
                        @endif
                    </div>
                    <img class="img-avatar"
                        src="{{ $prescriber->profile_photo == null ? asset('assets/img/default-profile.png') : Storage::disk('profiles')->url($prescriber->profile_photo) }}"
                        alt="">
                </div>
                <a href="{{ route('prescribers.profile',  $prescriber->prescriber_code ) }}">
                    <div class="block-content block-content-full block-content-sm bg-body-light">
                        <div class="font-w600 mb-5">{{ $prescriber->first_name }} {{ $prescriber->last_name }}</div>
                        <div class="font-size-sm text-muted">{{ $prescriber->type->title ?? '' }}</div>
                    </div>
                </a>
                {{-- <div class="block-content">
                    <div class="row items-push">
                        <div class="col-6">
                            <div class="mb-5"><i class="si si-users fa-2x"></i></div>
                            <div class="font-size-sm text-muted">9 Patients</div>
                        </div>
                        <div class="col-6">
                            <div class="mb-5"><i class="si si-calendar fa-2x"></i></div>
                            <div class="font-size-sm text-muted">2 Appointments</div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
        @endforeach
        @endif
        <!-- END Row #2 -->
    </div>
    <div class="float-right mb-15">
        {{ $prescribers->links('vendor.livewire.bootstrap') }}
    </div>

    <!-- Pop Out Modal -->
    <div class="modal fade" id="modal-prescriber" tabindex="-1" role="dialog" aria-labelledby="modal-popout"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-popout" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">
                            @if($showEditModal)
                            <span>Edit Prescriber</span>
                            @else
                            <span>Add Prescriber</span>
                            @endif
                        </h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <form wire:submit.prevent="{{ $showEditModal ? 'updatePrescriber' : 'createPrescriber' }}">
                            <div class="form-group row">
                                <div class="col-12 col-sm-12 text-center">
                                    <div class="form-group avatar-box">
                                        <div class="img-box">
                                            @if ($photo)
                                            <img src="{{ $photo->temporaryUrl() }}" width="150" height="150" alt="">
                                            @else
                                            <img src="{{ $profilePhoto == null ? asset('assets/img/default-profile.png') : Storage::disk('profiles')->url($profilePhoto) }}"
                                                width="150" height="150" alt="">
                                            @endif
                                        </div>
                                    </div>
                                    <button class="btn btn-outline-primary self-center" type="button" id="browseImg"
                                        type="button" onclick="document.getElementById('photo').click();">
                                        Browse Image
                                    </button>
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
                                        placeholder="Enter your firstname.." {{ $canUpdate }}>
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
                                        placeholder="Enter your lastname.." {{ $canUpdate }}>
                                    @error('last_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="firstname">Title/Role</label>
                                    <select class="form-control @error('prescriber_type') is-invalid @enderror"
                                        title="Prescriber Type" wire:model.defer="state.prescriber_type"
                                        id="prescriber_type" name="prescriber_type" size="1" {{ $canUpdate }}>
                                        @foreach ($prescriberTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('prescriber_type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label for="gender">Gender</label>
                                    <select class="form-control @error('gender') is-invalid @enderror" title="Gender"
                                        wire:model.defer="state.gender" id="gender" name="gender" size="1" {{ $canUpdate
                                        }}>
                                        <option value="Male">Male</option>
                                        <option value="Male">Female</option>
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
                                            class="form-control @error('phone_number') is-invalid @enderror" type="text"
                                            wire:model.defer="state.phone_number" id="phone_number" name="phone_number"
                                            placeholder="Enter your phone number.." {{ $canUpdate }}>
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fa fa-phone"></i>
                                            </span>
                                        </div>
                                    </div>
                                    @error('phone_number')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12" for="email">Email</label>
                                <div class="col-12">
                                    <div class="input-group">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            type="text" wire:model.defer="state.email" id="email" name="email"
                                            placeholder="Enter your email.." {{ $canUpdate }}>
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fa fa-envelope-o"></i>
                                            </span>
                                        </div>
                                    </div>
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            @if($showEditModal && Auth::user()->isAdmin())
                            <div class="form-group row">
                                <label class="col-12" for="password">Password</label>
                                <div class="col-12">
                                    <div class="input-group">
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror" type="text"
                                            wire:model.defer="state.password" id="password" name="password"
                                            placeholder="Enter your password..">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fa fa-lock"></i>
                                            </span>
                                        </div>
                                    </div>
                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12" for="password">Confirm Password</label>
                                <div class="col-12">
                                    <div class="input-group">
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror" type="text"
                                            wire:model.defer="state.password_confirmation" id="password_confirmation"
                                            name="password_confirmation" placeholder="Confirm your password..">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fa fa-lock"></i>
                                            </span>
                                        </div>
                                    </div>
                                    @error('password_confirmation')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            @endif
                            @if (Auth::user()->isAdmin())
                            <div class="form-group row">
                                <div class="col-12">
                                    <div class="custom-control custom-checkbox custom-control-inline mb-5">
                                        <input class="custom-control-input" type="checkbox" name="is_admin"
                                            id="is_admin" wire:model.defer="state.is_admin">
                                        <label class="custom-control-label" for="is_admin">Assign as
                                            ADMIN</label>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if (Auth::user()->isAdmin())
                            <div class="form-group row">
                                <div class="col-12">
                                    <button type="button" class="btn btn-alt-info" wire:loading
                                        wire:target="{{ $showEditModal ? 'updatePrescriber' : 'createPrescriber' }}">
                                        <span class="btn-loader icofont-spinner"></span>
                                    </button>
                                    <button type="submit" class="btn btn-alt-info" wire:loading.attr="hidden">
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
                    @if (Auth::user()->isAdmin())
                    <button type="button" class="btn btn-alt-danger" wire:click="deleteModal()">
                        <i class="fa fa-trash"></i> Delete
                    </button>
                    @endif
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END Pop Out Modal -->

    <!-- Slide Up Modal -->
    <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="modal-slideup"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-slideup" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Delete Prescriber</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <h5>Are you sure you want to delete this prescriber?</h5>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-alt-danger" wire:click.prevent="deletePrescriber">
                        <i class="fa fa-trash"></i> Confirm Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="title-role-modal" tabindex="-1" role="dialog" aria-labelledby="modal-popout"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-popout" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">
                            <span>New Title/Role</span>
                        </h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <form wire:submit.prevent="updateTitleRole">
                            <div class="form-group row">
                                <div class="col-4">
                                    <label for="initial">Initial</label>
                                    <input type="text" class="form-control @error('initial') is-invalid @enderror"
                                        wire:model.defer="initial" id="initial" name="initial"
                                        placeholder="Enter your initials.." {{ $canUpdate }}>
                                    @error('initial')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-8">
                                    <label for="title">Title/Role</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        wire:model.defer="title" id="title" name="title"
                                        placeholder="Enter your title/role.." {{ $canUpdate }}>
                                    @error('title')
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
                                        <i class="fa fa-save mr-5"></i>
                                        Update
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
</div>
<!-- end Add appointment modals -->


@push('scripts')
<script>
    $(document).ready(function() {
        toastr.options = {
            "positionClass": "toast-bottom-right",
            "progressBar": true,
        }

        window.addEventListener('hide-prescriber-modal', event => {
            $('#modal-prescriber').modal('hide');
            if(event.detail.message != 'none'){
                toastr.success(event.detail.message, 'Success!');
            }
        })

        window.addEventListener('show-error-toastr', event => {
            toastr.error(event.detail.message, 'Error!');
        })
    });
</script>
<script>
    window.addEventListener('show-prescriber-modal', event => {
        $('#modal-prescriber').modal('show');
    })

    window.addEventListener('show-delete-modal', event => {
        $('#delete-modal').modal('show');
    })

    window.addEventListener('hide-delete-modal', event => {
        $('#delete-modal').modal('hide');
        toastr.success(event.detail.message, 'Success!');
    })

    window.addEventListener('show-title-modal', event => {
        $('#title-role-modal').modal('show');
    })

    window.addEventListener('hide-title-modal', event => {
        $('#title-role-modal').modal('hide');
    })

        // window.addEventListener('hide-prescriber-modal', event => {
        //     $('#add-admin').modal('hide');
        // })
</script>
<script>
    // $('#gender').selectpicker({
    //         style: '',
    //         styleBase: 'form-control',
    //         tickIcon: 'icofont-check-alt'
    //     });

    //     $('#prescriber_type').selectpicker({
    //         style: '',
    //         styleBase: 'form-control',
    //         tickIcon: 'icofont-check-alt'
    //     });


    //     window.livewire.on('setGender', gender => {
    //         $('#gender').selectpicker('val', gender);
    //     });

    //     window.livewire.on('setPrescriberType', type => {
    //         $('#prescriber_type').selectpicker('val', gender);
    //     });
</script>
@endpush
