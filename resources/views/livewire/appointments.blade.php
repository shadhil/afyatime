<div>

    <h2 class="content-heading">Appointments </h2>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">All Patients' Appointments</h3>

            <div class="form-group row">
                <div class="col-md-12">
                    <div class="form-material form-material-primary">
                        <input type="text" class="form-control" wire:model="searchTerm"
                            wire:keydown.enter="searchAppointment" name="searchAppointment"
                            placeholder="Search Appointment" wire:keydown.enter="searchAppointment">
                    </div>
                </div>
            </div>
        </div>
        <div class="block-content">
            {{-- <p>The second way is to use <a href="be_ui_grid.html#cb-grid-rutil">responsive utility CSS classes</a>
                for
                hiding columns in various screen resolutions. This way you can hide less important columns and keep the
                most
                valuable on smaller screens. At the following example the <strong>Access</strong> column isn't visible
                on
                small and extra small screens and <strong>Email</strong> column isn't visible on extra small screens.
            </p> --}}
            <table class="table table-striped table-vcenter">
                <thead>
                    <tr>
                        <th style="width: 100px;">ID</th>
                        <th>Patient's Name</th>
                        <th class="d-none d-sm-table-cell text-center" style="width: 35%;">Date & Time</th>
                        <th class="d-none d-md-table-cell" width="15%">Prescriber</th>
                        <th class="d-none d-md-table-cell">Visits</th>
                        <th class="text-center" style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if (sizeof($appointments)>0)
                    @foreach ($appointments as $appointment)
                    <tr>
                        <td style="width: 100px;">
                            <a class="font-weight-bold"
                                href="{{ route('patients.profile', ['code' => $appointment->patient->patient_code]) }}">#{{
                                $appointment->patient->patient_code }}</a>
                        </td>
                        <td class="font-w600"> <a
                                href="{{ route('patients.profile', $appointment->patient->patient_code) }}"> {{
                                $appointment->patient->first_name }}
                                {{ $appointment->patient->last_name }} </a> </td>
                        <td class="d-none d-sm-table-cell text-center" style="width: 35%;">
                            {{ $appointment->dateOfVisit() }} {{
                            \Carbon\Carbon::parse($appointment->visit_time)->format('h:i A') }}
                        </td>
                        <td class="d-none d-md-table-cell">
                            {{ $appointment->prescriber->prescriber_type->initial ?? '' }}
                            {{ $appointment->prescriber->first_name }}
                            {{ $appointment->prescriber->last_name }}
                        </td>
                        <td class="d-none d-md-table-cell">
                            <span
                                class="badge {{ ($appointment->app_type == 'weekly') ? 'badge-primary' : 'badge-info'}}">
                                {{ Str::upper($appointment->app_type) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                @if ($appointment->visited() == \App\Models\Appointment::NOT_VISITED)
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="tooltip"
                                    title="Not Visited"
                                    wire:click="viewAppointmentModal('{{ $appointment->id }}', '{{
                                                                    $appointment->patient->first_name }} {{ $appointment->patient->last_name
                                                                    }}', '{{ $appointment->prescriber->type->initial ?? '' }} {{ $appointment->prescriber->first_name }} {{ $appointment->prescriber->last_name }}', '{{ \Carbon\Carbon::parse($appointment->date_of_visit)->format('l, F jS, Y') }}', '{{ \Carbon\Carbon::parse($appointment->visit_time)->format('h:i A') }}',  '{{ $appointment->app_type }}', '{{ $appointment->condition->condition }}', '{{ $appointment->received_by->prescriber_type->initial ?? '' }} {{ $appointment->received_by->first_name ?? '' }} {{ $appointment->received_by->last_name ?? '' }}', false)">
                                    <i class="fa fa-calendar-times-o"></i>
                                </button>
                                @elseif ($appointment->visited() == \App\Models\Appointment::VISITED)
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-success" data-toggle="tooltip"
                                        title="Visited"
                                        wire:click="viewAppointmentModal('{{ $appointment->id }}', '{{
                                                                    $appointment->patient->first_name }} {{ $appointment->patient->last_name
                                                                    }}', '{{ $appointment->prescriber->type->initial ?? '' }} {{ $appointment->prescriber->first_name }} {{ $appointment->prescriber->last_name }}', '{{ \Carbon\Carbon::parse($appointment->date_of_visit)->format('l, F jS, Y') }}', '{{ \Carbon\Carbon::parse($appointment->visit_time)->format('h:i A') }}',  '{{ $appointment->app_type }}', '{{ $appointment->condition->condition }}', '{{ $appointment->received_by->prescriber_type->initial ?? '' }} {{ $appointment->received_by->first_name ?? '' }} {{ $appointment->received_by->last_name ?? '' }}', false)">
                                        <i class="fa fa-check-square-o"></i>
                                    </button>
                                </div>
                                @else
                                <button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip"
                                    title="View"
                                    wire:click="viewAppointmentModal('{{ $appointment->id }}', '{{
                                                                    $appointment->patient->first_name }} {{ $appointment->patient->last_name
                                                                    }}', '{{ $appointment->prescriber->type->initial ?? '' }} {{ $appointment->prescriber->first_name }} {{ $appointment->prescriber->last_name }}', '{{ \Carbon\Carbon::parse($appointment->date_of_visit)->format('l, F jS, Y') }}', '{{ \Carbon\Carbon::parse($appointment->visit_time)->format('h:i A') }}',  '{{ $appointment->app_type }}', '{{ $appointment->condition->condition }}', '{{ $appointment->received_by->prescriber_type->initial ?? '' }} {{ $appointment->received_by->first_name ?? '' }} {{ $appointment->received_by->last_name ?? '' }}', {{ $appointment->prescriber_id }})">
                                                                    <i class=" fa fa-eye"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="float-right">
        {{ $appointments->links('vendor.livewire.bootstrap') }}
    </div>
    {{-- <div class="float-right">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)" tabindex="-1" aria-label="Previous">
                        <span aria-hidden="true">
                            <i class="fa fa-angle-double-left"></i>
                        </span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
                <li class="page-item active">
                    <a class="page-link" href="javascript:void(0)">1</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)">2</a>
                </li>
                <li class="page-item disabled">
                    <a class="page-link" href="javascript:void(0)">3</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)" aria-label="Next">
                        <span aria-hidden="true">
                            <i class="fa fa-angle-double-right"></i>
                        </span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div> --}}

    <div class="modal fade" id="view-modal" tabindex="-1" role="dialog" aria-labelledby="modal-slideup"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-slideup" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Patient's Appointment</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <table class="table table-striped table-borderless mt-20">
                            <tbody>
                                <tr>
                                    <td class="font-w600">Patient</td>
                                    <td>{{ $vPatient }}</td>
                                </tr>
                                <tr>
                                    <td class="font-w600">Prescriber</td>
                                    <td>{{ $vPrescriber }}</td>
                                </tr>
                                <tr>
                                    <td class="font-w600">Date</td>
                                    <td>{{ $vDate }}</td>
                                </tr>
                                <tr>
                                    <td class="font-w600">Time</td>
                                    <td>{{ $vTime }}</td>
                                </tr>
                                <tr>
                                    <td class="font-w600">Condition/Disease</td>
                                    <td>
                                        {{ $vCondition }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-w600">Appointment Type</td>
                                    <td>
                                        {{ $vType }} Visits
                                    </td>
                                </tr>
                                @if ($vReceiver != '')
                                <tr>
                                    <td class="font-w600">Attendence Confirmed by</td>
                                    <td>{{ $vReceiver }} </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>
@push('scripts')
<script>
    window.addEventListener('show-view-modal', event => {
        $('#view-modal').modal('show');
    })

    window.addEventListener('hide-view-modal', event => {
        $('#view-modal').modal('hide');
        // toastr.success(event.detail.message, 'Success!');
    })

    window.addEventListener('show-error-toastr', event => {
        toastr.error(event.detail.message, 'Error!');
    })

</script>
@endpush
