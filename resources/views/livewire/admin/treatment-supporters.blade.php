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
</div>

