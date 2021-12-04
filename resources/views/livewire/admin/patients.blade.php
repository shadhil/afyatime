<div>
    <div class="main-content-wrap">
        <header class="page-header">
            <h1 class="page-title">Patients</h1>
            {{-- <form class="app-search d-none d-md-block" wire:submit.prevent="searchPatient">
                <div class="form-group typeahead__container with-suffix-icon mb-0">
                    <div class="typeahead__field">
                        <div class="typeahead__query">
                            <input class="form-control autocomplete-control topbar-search" type="search"
                                placeholder="Type patient's name" wire:model="searchTerm"
                                wire:keydown.enter="searchPatient">
                            <div class="suffix-icon icofont-search"></div>
                        </div>
                    </div>
                </div>
            </form> --}}
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
                                    <th scope="col">Code</th>
                                    <th scope="col">Age</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Number</th>
                                    <th scope="col" align="center">Last visit</th>
                                    <th scope="col" calss="text-center">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (sizeof($patients)>0)
                                @foreach ($patients as $patient)
                                <tr>
                                    <td>
                                        <img src="{{ $patient->photo == null ? asset('assets/img/default-profile.png') : Storage::disk('profiles')->url($patient->photo) }}"
                                            alt="" width="40" height="40" class="rounded-500">
                                    </td>
                                    <td>
                                        <strong>{{ $patient->first_name }} {{ $patient->first_name }}</strong>
                                    </td>
                                    <td>
                                        <div class="text-muted">{{ $patient->patient_code }}</div>
                                    </td>
                                    <td>
                                        <div class="text-muted text-nowrap">
                                            {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }}</div>
                                    </td>
                                    <td>
                                        <div class="address-col">{{ $patient->location }}</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center nowrap text-primary">
                                            <span class="icofont-ui-cell-phone p-0 mr-2"></span>
                                            {{ $patient->phone_number }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-muted text-nowrap text-center">-</div>
                                    </td>
                                    <td align="center"><span class="badge badge-success">Cleared</span></td>
                                    <td>
                                        <div class="actions">
                                            <a href="{{ route('patients.profile', $patient->code) }}"
                                                class="btn btn-dark btn-sm btn-square rounded-pill">
                                                <span class="btn-icon icofont-external-link"></span>
                                            </a>
                                            <button class="btn btn-info btn-sm btn-square rounded-pill"
                                                wire:click="editPatient({{ $patient->id }})">
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
                                    <td colspan="9" align="center">No Patient Found</td>
                                </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $patients->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
