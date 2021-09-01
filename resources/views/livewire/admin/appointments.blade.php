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
                                    <th scope="col">Photo</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Visit time</th>
                                    <th scope="col">Number</th>
                                    <th scope="col">Doctor</th>
                                    <th scope="col">Injury / Condition</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (sizeof($appointments)>0)
                                @foreach ($appointments as $appointment)
                                <tr>
                                    <td>
                                        <img src="{{ $appointment->photo == null ? asset('assets/img/default-profile.png') : Storage::disk('profiles')->url($appointment->photo) }}"
                                            alt="" width="40" height="40" class="rounded-500">
                                    </td>
                                    <td>
                                        <strong>{{ $appointment->pf_name }} {{ $appointment->pl_name }}</strong>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center nowrap text-primary">
                                            <span class="icofont-ui-email p-0 mr-2"></span>
                                            {{ $appointment->email ?? '-' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-muted text-nowrap">
                                            {{ \Carbon\Carbon::parse($appointment->date_of_visit)->format('d/m/Y')  }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-muted text-nowrap">
                                            @if (empty($appointment->time_to))
                                            {{ \Carbon\Carbon::parse($appointment->time_from)->format('h:i A') }}
                                            @else
                                            {{ \Carbon\Carbon::parse($appointment->time_from)->format('h:i A') }}
                                            -
                                            {{ \Carbon\Carbon::parse($appointment->time_to)->format('h:i A') }}
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center nowrap text-primary">
                                            <span class="icofont-ui-cell-phone p-0 mr-2"></span>
                                            {{ $appointment->phone_number }}
                                        </div>
                                    </td>
                                    <td>{{ $appointment->initial }} {{ $appointment->last_name }}</td>
                                    <td>{{ $appointment->condition }}</td>
                                    <td>
                                        <div class="actions">
                                            <button class="btn btn-info btn-sm btn-square rounded-pill">
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
