<div class="content">
    <div class="row">
        <!-- User -->
        <div class="col-lg-4 col-xl-3">
            <!-- Account -->
            <div class="block block-rounded font-w600">
                <div class="block-content block-content-full bg-gd-sea text-center">
                    <img class="img-avatar img-avatar-thumb"
                        src="{{ $patient->photo == null ? asset('assets/img/default-profile.png') : Storage::disk('profiles')->url($patient->photo) }}"
                        alt="">
                </div>
                <div class="block-content block-content-full text-center">
                    <div class="border-b pb-15">
                        {{ $patient->first_name }} {{ $patient->last_name }}<br>
                        <a class="text-muted font-w400" href="javascript:void(0)"> {{ Str::ucfirst($patient->gender) }}
                            - {{
                            \Carbon\Carbon::parse($patient->date_of_birth)->age }} Years Old</a>
                    </div>
                </div>
                <div class="block-content pull-t">
                    <a class="font-w600" href="javascript:void(0)">Patient Code</a>
                    <p class="text-muted">#{{ $patient->patient_code }}</p>
                    <a class="font-w600" href="javascript:void(0)">Location</a>
                    <p class="text-muted">{{ $patient->location }} - {{ $patient->district->region->name }}, {{
                        $patient->district->name }}</p>
                    @if ($patient->email ?? '' != '' )
                    <a class="font-w600" href="javascript:void(0)">Email</a>
                    <p class="text-muted">{{ $patient->email ?? '- - -' }}</p>
                    @endif
                    <a class="font-w600" href="javascript:void(0)">Phone</a>
                    <p class="text-muted">{{ $patient->phone_number ?? '- - -' }}</p>
                    <a class="font-w600" href="javascript:void(0)">Appointments</a>
                    <p class="text-muted">{{ $patient->appointments->count() }}</p>
                    @if ($patient->tensel_leader ?? '' != '' )
                    <a class="font-w600" href="javascript:void(0)">Tensel Leader</a>
                    <p class="text-muted">{{ $patient->tensel_leader ?? '- - -' }}</p>
                    @endif
                    @if ($patient->tensel_leader_phone ?? '' != '' )
                    <a class="font-w600" href="javascript:void(0)">Tensel Leader's Phone</a>
                    <p class="text-muted">{{ $patient->tensel_leader_phone ?? '- - -' }}</p>
                    @endif
                </div>
            </div>
            <!-- END Account -->
            <br>
            <div class="block block-rounded font-w600">
                <div class="block-content bg-gd-sea text-center">
                    <div class="pb-15 text-white">
                        Treatment Supporter<br>
                    </div>
                </div>
                @if ($patient->supporter_id == NULL)
                <div class="block-options-item text-center p-10">
                    <p>
                        No Supporter Assigned
                    </p>
                </div>
                @else
                <div class="block-content pull-t mt-0">
                    <a class="font-w600" href="javascript:void(0)">Supporter' Name</a>
                    <p class="text-muted">{{ $patient->supporter->full_name }}</p>
                    <a class="font-w600" href="javascript:void(0)">Location</a>
                    <p class="text-muted">{{ $patient->supporter->location }} - {{
                        $patient->supporter->district->region->name }}, {{
                        $patient->supporter->district->name }}</p>
                    @if ($patient->supporter->email ?? '' != '')
                    <a class="font-w600" href="javascript:void(0)">Email</a>
                    <p class="text-muted">{{ $patient->supporter->email ?? '- - -' }}</p>
                    @endif
                    <a class="font-w600" href="javascript:void(0)">Phone</a>
                    <p class="text-muted">{{ $patient->supporter->phone_number ?? '- - -' }}</p>
                </div>
                @endif
            </div>
        </div>
        <!-- END User -->

        <!-- Updates -->
        <div class="col-lg-8 col-xl-9">
            <div class="block block-rounded block-bordered">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Patient's Appointments</h3>
                    <div class="block-options">
                        <div class="block-options-item">

                        </div>
                    </div>
                </div>
                <div class="block-content">
                    <table class="table table-hover table-vcenter">
                        <thead>
                            <tr>
                                <th class="d-none d-sm-table-cell">Prescriber</th>
                                <th width="30%">Date</th>
                                <th class="d-none d-sm-table-cell text-center">Reminder</th>
                                <th class="text-center" style="width: 100px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (sizeof($appointments)>0)
                            @foreach ($appointments as $appointment)
                            <tr>
                                <td class="d-none d-sm-table-cell"><a href="javascript:void(0)">{{
                                        $appointment->prescriber->prescriber_type->initial ?? '' }} {{
                                        $appointment->prescriber->first_name }} {{ $appointment->prescriber->last_name
                                        }}</a></td>
                                <td width="30%">
                                    {{ $appointment->dateOfVisit() }} {{
                                    \Carbon\Carbon::parse($appointment->visit_time)->format('h:i A') }}
                                </td>
                                <td class="d-none d-sm-table-cell text-center">
                                    <span
                                        class="badge {{ $appointment->app_type == 'weekly' ? 'badge-info' : 'badge-success' }}">{{
                                        $appointment->app_type }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        @if ($appointment->visited() == \App\Models\Appointment::NOT_VISITED)
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="tooltip"
                                            title="Not Visited" wire:click="viewAppointmentModal('{{ $appointment->id }}', '{{
                                        $appointment->prescriber->type->initial ?? '' }} {{
                                        $appointment->prescriber->first_name }} {{ $appointment->prescriber->last_name
                                        }}', '{{ \Carbon\Carbon::parse($appointment->date_of_visit)->format('l, F jS, Y') }}', '{{ \Carbon\Carbon::parse($appointment->visit_time)->format('h:i A') }}',  '{{ $appointment->app_type }}', '{{ $appointment->condition->condition }}', '{{
                                        $appointment->received_by->prescriber_type->initial ?? '' }} {{
                                        $appointment->received_by->first_name ?? '' }} {{ $appointment->received_by->last_name ?? ''
                                        }}', false)">
                                            <i class="fa fa-calendar-times-o"></i>
                                        </button>
                                        @elseif ($appointment->visited() == \App\Models\Appointment::VISITED)
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-success" data-toggle="tooltip"
                                                title="Visited" wire:click="viewAppointmentModal('{{ $appointment->id }}', '{{
                                        $appointment->prescriber->prescriber_type->initial ?? '' }} {{
                                        $appointment->prescriber->first_name }} {{ $appointment->prescriber->last_name
                                        }}', '{{ \Carbon\Carbon::parse($appointment->date_of_visit)->format('l, F jS, Y') }}', '{{ \Carbon\Carbon::parse($appointment->visit_time)->format('h:i A') }}',  '{{ $appointment->app_type }}', '{{ $appointment->condition->condition }}', '{{
                                        $appointment->receiver->prescriber_type->initial ?? '' }} {{
                                        $appointment->receiver->first_name ?? '' }} {{ $appointment->receiver->last_name ?? ''
                                        }}', false)">
                                                <i class="fa fa-check-square-o"></i>
                                            </button>
                                        </div>
                                        @else
                                        <button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip"
                                            title="View" wire:click="viewAppointmentModal('{{ $appointment->id }}', '{{
                                        $appointment->prescriber->prescriber_type->initial ?? '' }} {{
                                        $appointment->prescriber->first_name }} {{ $appointment->prescriber->last_name
                                        }}', '{{ \Carbon\Carbon::parse($appointment->date_of_visit)->format('l, F jS, Y') }}', '{{ \Carbon\Carbon::parse($appointment->visit_time)->format('h:i A') }}',  '{{ $appointment->app_type }}', '{{ $appointment->condition->condition }}', '{{
                                        $appointment->receiver->prescriber_type->initial ?? '' }} {{
                                        $appointment->receiver->first_name ?? '' }} {{ $appointment->receiver->last_name ?? ''
                                        }}', {{ $appointment->updatable() }})">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr class="mt-5">
                                <td colspan="4" class="text-center text-info mt-5">No Appointment Found</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <!-- END Updates -->
    </div>


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
                    @if (is_subscribed())
                    @if ($showEditModal)
                    <button type="button" class="btn btn-alt-info" wire:click="editAppointment({{ $appointmentId }})">
                        <i class="fa fa-edit"></i> Edit Appointment
                    </button>
                    @endif
                    @endif
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    jQuery(function(){Codebase.helpers(['flatpickr', 'datepicker']);});
</script>
<script>
    $(document).ready(function() {
        toastr.options = {
            "positionClass": "toast-bottom-right",
            "progressBar": true,
        }

        window.addEventListener('hide-appointment-modal', event => {
            $('#modal-appointment').modal('hide');
            if(event.detail.message != 'none'){
                toastr.success(event.detail.message, 'Success!');
            }
        })

        window.addEventListener('hide-condition-modal', event => {
            $('#modal-condition').modal('hide');
            toastr.success(event.detail.message, 'Success!');
        })

        window.addEventListener('hide-patient-modal', event => {
            $('#modal-patient').modal('hide');
            toastr.success(event.detail.message, 'Success!');
        })

        window.addEventListener('hide-supporter-modal', event => {
            $('#modal-supporter').modal('hide');
            if (event.detail.message != 'none') {
                toastr.success(event.detail.message, 'Success!');
            }
            if (event.detail.url != 'none') {
            window.location.href = event.detail.url;
            }
        })
    });
</script>
<script>
    window.addEventListener('show-patient-modal', event => {
        $('#modal-patient').modal('show');
    })

    window.addEventListener('show-supporter-modal', event => {
        $('#modal-supporter').modal('show');
    })

    window.addEventListener('show-appointment-modal', event => {
        $('#modal-appointment').modal('show');
    })

    window.addEventListener('show-condition-modal', event => {
        $('#modal-condition').modal('show');
    })

    window.addEventListener('show-delete-modal', event => {
        $('#delete-modal').modal('show');
    })

    window.addEventListener('hide-delete-modal', event => {
        $('#delete-modal').modal('hide');
        toastr.success(event.detail.message, 'Success!');
    })

    window.addEventListener('show-complete-modal', event => {
        $('#complete-modal').modal('show');
    })

    window.addEventListener('hide-complete-modal', event => {
        $('#complete-modal').modal('hide');
        toastr.success(event.detail.message, 'Success!');
    })

    window.addEventListener('show-view-modal', event => {
        $('#view-modal').modal('show');
    })

    window.addEventListener('hide-view-modal', event => {
        $('#view-modal').modal('hide');
        // toastr.success(event.detail.message, 'Success!');
    })

    window.addEventListener('show-error-toastr', event => {
        $('#complete-modal').modal('hide');
        toastr.error(event.detail.message, 'Error!');
    })

    //  window.addEventListener('show-delete-modal', event => {
    //     $('#confirmationModal').modal('show');
    // })

    // window.addEventListener('hide-delete-modal', event => {
    //     $('#confirmationModal').modal('hide');
    //     toastr.success(event.detail.message, 'Success!');
    // })

        // window.addEventListener('hide-appointment-modal', event => {
        //     $('#add-admin').modal('hide');
        // })
</script>
@endpush
