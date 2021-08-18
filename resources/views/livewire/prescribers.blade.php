<div>
    <div class="main-content-wrap">
        <header class="page-header">
            <h1 class="page-title">Prescribers</h1>

            <form class="app-search d-none d-md-block" wire:submit.prevent="searchPrescriber">
                <div class="form-group typeahead__container with-suffix-icon mb-0">
                    <div class="typeahead__field">
                        <div class="typeahead__query">
                            <input class="form-control autocomplete-control topbar-search" type="search"
                                placeholder="Type prescriber's name" wire:model="searchTerm"
                                wire:keydown.enter="searchPrescriber">
                            <div class="suffix-icon icofont-search"></div>
                        </div>
                    </div>
                </div>
            </form>
        </header>

        <div class="page-content">
            <div class="row">
                @if (sizeof($prescribers)>0)
                @foreach ($prescribers as $prescriber)
                <div class="col-12 col-md-4">
                    <div class="contact">
                        <div class="img-box">
                            <img src="{{ $prescriber->profile_photo == null ? asset('assets/img/default-profile.png') : Storage::disk('profiles')->url($prescriber->profile_photo) }}"
                                width="400" height="400" alt="">
                        </div>

                        <div class="info-box">
                            <h4 class="name">{{ $prescriber->initial }} {{ $prescriber->first_name }}
                                {{ $prescriber->last_name }}</h4>

                            <p class="role">{{ $prescriber->title }}</p>

                            <div class="social">
                                <a href="#" class="link icofont-email"></a>
                                <a href="#" class="link icofont-phone"></a>
                                <span wire:click.prevent="editPrescriber({{ $prescriber->id }})"
                                    class="link icofont-edit"></span>
                            </div>

                            <p class="address">{{ $prescriber->email }}</p>

                            <div class="button-box">
                                <a href="doctor.html" class="btn btn-primary">View profile</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                @else
                <div class="col-md-12">
                    <div class="contact">

                        <div class="info-box">
                            <p class="address">No Prescriber found</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            @if (Auth::user()->account_type == 'prescriber-admin' || Auth::user()->account_type == 'organization')
            <div class="add-action-box">
                <button class="btn btn-dark btn-lg btn-square rounded-pill" wire:click="addPrescriber">
                    <span class="btn-icon icofont-contact-add"></span>
                </button>
            </div>
            @endif
        </div>
    </div>

    <!-- Add appointment modals -->
    <div class="modal fade" id="modal-prescriber" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @if($showEditModal)
                        <span>Edit Prescriber</span>
                        @else
                        <span>Add New Prescriber</span>
                        @endif
                    </h5>
                </div>
                <form autocomplete="off"
                    wire:submit.prevent="{{ $showEditModal ? 'updatePrescriber' : 'createPrescriber' }}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-sm-3">
                            </div>
                            <div class="col-12 col-sm-6 text-center">
                                <div class="form-group avatar-box">
                                    <div class="img-box">
                                        @if ($photo)
                                        <img src="{{ $photo->temporaryUrl() }}" width="200" height="200" alt="">
                                        @else
                                        <img src="{{ $profilePhoto == null ? asset('assets/img/default-profile.png') : Storage::disk('profiles')->url($profilePhoto) }}"
                                            width="200" height="200" alt="">
                                        @endif
                                    </div>
                                </div>
                                <button class="btn btn-outline-primary self-center" type="button" id="browseImg"
                                    type="button" onclick="document.getElementById('photo').click();">
                                    Browse Image
                                </button>
                                <input wire:model="photo" type="file" accept="image/*" style="display:none;" id="photo"
                                    name="photo">
                                @if ($photo)
                                {{ $photo->getClientOriginalName() }}
                                @endif
                            </div>
                            <div class="col-12 col-sm-3">
                            </div>
                        </div>
                        <br />

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

                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <select class="form-control @error('prescriber_type') is-invalid @enderror"
                                        title="Prescriber Type" wire:model.defer="state.prescriber_type"
                                        id="prescriber_type" name="prescriber_type">
                                        <option class="d-none">Title/Role</option>
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
                        <div class="custom-control custom-switch mb-3">
                            <input type="checkbox" class="custom-control-input" id="customCheck2"
                                wire:model.defer="state.is_admin">
                            <label class="custom-control-label" for="customCheck2">Checkbox label</label>
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
            toastr.success(event.detail.message, 'Success!');
        })
    });
</script>
<script>
    window.addEventListener('show-prescriber-modal', event => {
        $('#modal-prescriber').modal('show');
    })

    window.addEventListener('show-delete-modal', event => {
        $('#confirmationModal').modal('show');
    })

    window.addEventListener('hide-delete-modal', event => {
        $('#confirmationModal').modal('hide');
        toastr.success(event.detail.message, 'Success!');
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
</div>
