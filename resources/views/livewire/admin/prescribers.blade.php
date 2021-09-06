<div>
    <div class="main-content-wrap">
        <header class="page-header">
            <h1 class="page-title">Prescribers</h1>

            {{-- <form class="app-search d-none d-md-block" wire:submit.prevent="searchPrescriber">
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
            </form> --}}
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
        </div>
    </div>

</div>

