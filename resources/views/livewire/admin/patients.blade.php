<div class="content">
    <h2 class="content-heading">{{ $orgName }}</h2>
    <div class="block-header">
        <h3 class="block-title">All Patients</h3>
        {{-- <div class="block-title"> --}}


            <div class="form-group row">
                <div class="col-md-12">
                    <div class="form-material form-material-primary">
                        <input type="text" class="form-control" wire:model="searchTerm"
                            wire:keydown.enter="searchPatient" name="searchPatient" placeholder="Search Patient"
                            wire:keydown.enter="searchPatient">
                    </div>
                </div>
            </div>
            {{--
        </div> --}}
    </div>
    @if (sizeof($patients)>0)
    <div class="row">
        @foreach ($patients as $patient)
        @if ($patient->lastAppointment->date_of_visit ?? '' >= now())
        <div class="col-md-4 col-xl-3">
            <a class="block text-center" href="{{ route('patients.profile', ['code' => $patient->patient_code]) }}">
                <div class="block-content block-content-full bg-gd-dusk">
                    <img class="img-avatar img-avatar-thumb"
                        src="{{ $patient->photo == null ? asset('assets/base/media/avatars/avatar.jpg') : Storage::disk('profiles')->url($patient->photo) }}"
                        alt="">
                </div>
                <div class="block-content block-content-full">
                    <div class="font-w600 mb-5">{{ $patient->first_name }} {{ $patient->last_name }}</div>
                    <div class="font-size-sm text-muted">#{{ $patient->patient_code }}</div>
                </div>
            </a>
        </div>
        @else
        <div class="col-md-4 col-xl-3">
            <a class="block block-link-pop text-center"
                href="{{ route('patients.profile', ['code' => $patient->patient_code]) }}">
                <div class="block-content block-content-full">
                    <img class="img-avatar img-avatar-thumb"
                        src="{{ $patient->photo == null ? asset('assets/base/media/avatars/avatar.jpg') : Storage::disk('profiles')->url($patient->photo) }}"
                        alt="">
                </div>
                <div class="block-content block-content-full bg-body-light">
                    <div class="font-w600 mb-5">{{ $patient->first_name }} {{ $patient->last_name }}</div>
                    <div class="font-size-sm text-muted">#{{ $patient->patient_code }}</div>
                </div>
            </a>
        </div>
        @endif
        @endforeach
    </div>
    <div class="float-right mb-15">
        {{ $patients->links('vendor.livewire.bootstrap') }}
    </div>
    @else
    <div class="row mb-15">
        <div class="col-sm-12 col-xl-12 text-center">
            No Patient Found
        </div>
    </div>
    @endif

</div>
