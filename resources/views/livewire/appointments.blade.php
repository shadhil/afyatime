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
                                <tr class="bg-primary text-white">
                                    <th scope="col">Photo</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Visit Date</th>
                                    <th scope="col"> Time</th>
                                    <th scope="col">Number</th>
                                    <th scope="col">Prescriber</th>
                                    <th scope="col">Injury / Condition</th>
                                    <th scope="col" class="text-center">Reminder</th>
                                    <th scope="col">Actions</th>
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
                                            {{ \Carbon\Carbon::parse($appointment->date_of_visit)->format('d/m/Y')  }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-muted text-nowrap">
                                            {{ \Carbon\Carbon::parse($appointment->visit_time)->format('h:i A') }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center nowrap text-primary">
                                            <span class="icofont-ui-cell-phone p-0 mr-2"></span>
                                            {{ $appointment->patient->phone_number }}
                                        </div>
                                    </td>
                                    <td>{{ $appointment->prescriber->prescriber_type->initial ?? '' }}
                                        {{ $appointment->prescriber->first_name }}
                                        {{ $appointment->prescriber->last_name }}</td>
                                    <td>{{ $appointment->condition->condition }}</td>
                                    <td align="center">
                                        <span
                                            class="badge badge-sm text-white {{ ($appointment->app_type == 'weekly') ? 'badge-success' : 'badge-danger'}} ">{{ Str::upper($appointment->app_type) }}
                                            VISIT</span>
                                    </td>
                                    <td>
                                        <div class="actions">
                                            <a href="{{ route('patient-profile', $appointment->patient->id) }}"
                                                type="button" class="btn btn-primary btn-sm text-white">
                                                <span class="btn-icon icofont-eye-alt"> Profile </span>
                                            </a>
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

                    <div class="mt-4 float-right">
                        {{ $appointments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
