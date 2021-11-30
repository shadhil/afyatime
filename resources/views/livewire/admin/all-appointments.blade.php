<div>
    <div class="main-content-wrap">
        <header class="page-header">
            <h1 class="page-title">Appointments</h1>
        </header>

        <div class="page-content">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col" class="d-sm-none d-md-block">Photo</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Visit time</th>
                                    <th scope="col" class="d-sm-none d-md-block">Organization</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (sizeof($appointments)>0)
                                @foreach ($appointments as $appointment)
                                <tr>
                                    <td>
                                        <img src="{{ $appointment->patient->photo == null ? asset('assets/img/default-profile.png') : Storage::disk('profiles')->url($appointment->patient->photo) }}"
                                            alt="" width="40" height="40" class="rounded-500">
                                    </td>
                                    <td>
                                        <strong>{{ $appointment->patient->first_name }}
                                            {{ $appointment->patient->last_name }}</strong>
                                    </td>
                                    <td>
                                        <div class="text-muted text-nowrap">
                                            {{ \Carbon\Carbon::parse($appointment->date_of_visit)->format('d/m/Y') }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-muted text-nowrap">
                                            {{ \Carbon\Carbon::parse($appointment->visit_time)->format('h:i A') }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center nowrap text-primary">
                                            {{ $appointment->organization->name }}
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="9" align="center">No Appointment Found</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $appointments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
