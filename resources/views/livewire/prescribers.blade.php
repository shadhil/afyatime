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
                            <img src="{{ $prescriber->profile_photo }}" width="400" height="400" alt="">
                        </div>

                        <div class="info-box">
                            <h4 class="name">{{ $prescriber->initial }} {{ $prescriber->first_name }}
                                {{ $prescriber->last_name }}</h4>

                            <p class="role">{{ $prescriber->title }}</p>

                            {{-- <p class="address">795 Folsom Ave, Suite 600 San Francisco, CADGE 94107</p> --}}

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

            <div class="add-action-box">
                <button class="btn btn-dark btn-lg btn-square rounded-pill" data-toggle="modal"
                    data-target="#add-doctor">
                    <span class="btn-icon icofont-contact-add"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Add appointment modals -->
    <div class="modal fade" id="add-doctor" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add doctor</h5>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-12 col-sm-3">
                            </div>
                            <div class="col-12 col-sm-6 center">
                                <div class="form-group avatar-box">
                                    <div class="img-box">
                                        <img src="../assets/content/doctor-400-3.jpg" width="200" height="200" alt="">
                                    </div>
                                </div>
                                <button class="btn btn-outline-primary self-center" type="button">
                                    Select prescriber's image
                                </button>
                            </div>
                            <div class="col-12 col-sm-3">
                            </div>
                        </div>
                        <br />

                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="First name">
                        </div>

                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Last name">
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <input class="form-control" type="text" placeholder="Speciality">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <select class="selectpicker" title="Gender">
                                        <option class="d-none">Gender</option>
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <textarea class="form-control" placeholder="Address" rows="3"></textarea>
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
                    </form>
                </div>
                <div class="modal-footer d-block">
                    <div class="actions justify-content-between">
                        <button type="button" class="btn btn-error" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-info">Add doctor</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end Add appointment modals -->
</div>
