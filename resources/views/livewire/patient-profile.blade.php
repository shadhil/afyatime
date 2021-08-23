<div>
    <div class="main-content-wrap">
        <div class="page-content">

            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="card bg-light personal-info-card">
                        <img src="{{ asset('assets/content/user-profile.jpg') }}" class="card-img-top" alt="">

                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3 user-actions">
                                <img src="{{ $patient->photo == null ? asset('assets/img/default-profile.png') : Storage::disk('profiles')->url($patient->photo) }}"
                                    width="100" height="100" alt="" class="rounded-500 mr-4">

                                <button type="button"
                                    class="btn btn-danger rounded-500">#{{ $patient->patient_code }}</button>
                            </div>


                            <p class="text-muted">{{ $patient->first_name }} {{ $patient->last_name }}</p>

                            <h6 class="mt-0 mb-0">Date of Birth</h6>
                            <p>{{ \Carbon\Carbon::parse($patient->date_of_birth)->format('F d, Y') }}</p>
                            <h6 class="mt-0 mb-0">Gender</h6>
                            <p>{{ $patient->gender }}</p>
                            <h6 class="mt-0 mb-0">Address</h6>
                            <p>{{ $patient->location }} - {{ $patient->district }}, {{ $patient->region }}</p>
                            <h6 class="mt-0 mb-0">Email</h6>
                            <p>{{ $patient->email }}</p>
                            <h6 class="mt-0 mb-0">Phone</h6>
                            <p>{{ $patient->phone_number }}</p>
                            @if ($patient->tensel_leader)
                            <h6 class="mt-0 mb-0">Tensel Leader</h6>
                            <p>{{ $patient->tensel_leader }} <small>({{ $patient->tensel_leader_phone }})</small> </p>
                            @endif
                            <h6 class="mt-0 mb-0">Treatment Supporter</h6>
                            <p>{{ $patient->full_name ?? '-' }}</p>

                        </div>
                    </div>

                    <div class="card ">
                        <div class="card-header">
                            Condition(s)
                        </div>
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col" class="text-right">Created at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (sizeof($conditions)>0)
                                    @foreach ($conditions as $condition)
                                    <tr>
                                        <td class="text-muted">{{ $condition->condition }}</td>
                                        <td class="text-right"><span
                                                class="badge badge-success rounded-0">{{ \Carbon\Carbon::parse($condition->created_at)->format('d/m/Y') }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="2" align="center">No Condition!</td>
                                    </tr>

                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card mb-md-0">
                        <div class="card-header">
                            Prescriber(s)
                        </div>
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col" class="text-right"> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (sizeof($prescribers)>0)
                                    @foreach ($prescribers as $prescriber)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $prescriber->profile_photo == null ? asset('assets/img/default-profile.png') : Storage::disk('profiles')->url($prescriber->profile_photo) }}"
                                                    alt="" width="40" height="40" class="rounded-500 mr-3">
                                                <strong>{{ $prescriber->first_name }}
                                                    {{ $prescriber->last_name }}</strong>
                                            </div>
                                        </td>
                                        <td class="text-right text-muted">
                                            {{-- {{ \Carbon\Carbon::parse($prescriber->date_of_visit)->format('M d, Y') }}
                                            --}}
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="2" align="center">No Prescriber!</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="col-12 col-md-8">
                    <div class="card mb-0">
                        <div class="card-header">
                            Appointments(s)
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">Date</th>
                                            <th scope="col" class="text-center">Visit Time</th>
                                            <th scope="col" class="text-center">Prescriber</th>
                                            <th scope="col" class="text-center">Candition</th>
                                            <th scope="col" class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (sizeof($appointments)>0)
                                        @foreach ($appointments as $appointment)
                                        <tr>
                                            <td align="center">
                                                <p>{{ \Carbon\Carbon::parse($appointment->date_of_visit)->format('d/m/Y')  }}
                                                </p>
                                            </td>
                                            <td align="center">
                                                @if (empty($appointment->time_to))
                                                <p class="text-nowrap">
                                                    {{ \Carbon\Carbon::parse($appointment->time_from)->format('h:i A') }}
                                                </p>
                                                @else
                                                <p class="text-nowrap">
                                                    {{ \Carbon\Carbon::parse($appointment->time_from)->format('h:i A') }}
                                                    -
                                                    {{ \Carbon\Carbon::parse($appointment->time_to)->format('h:i A') }}
                                                </p>
                                                @endif

                                            </td>
                                            <td align="center">
                                                <strong>{{ $appointment->first_name }}
                                                    {{ $appointment->last_name }}</strong>
                                            </td>
                                            <td align="center">
                                                <p>{{ $appointment->condition }}</p>
                                            </td>
                                            <td align="center">
                                                <div class="actions">
                                                    <a href="" class="btn btn-dark btn-sm btn-square rounded-pill">
                                                        <span class="btn-icon icofont-external-link"></span>
                                                    </a>
                                                    <button class="btn btn-info btn-sm btn-square rounded-pill"
                                                        wire:click="editAppointment({{ $appointment->id }})">
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
                                            <td colspan="5" align="center">No Appointment Found!</td>
                                        </tr>
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if (Str::contains('prescriber', Auth::user()->org_id))
            <div class="add-action-box">
                <button class="btn btn-primary btn-lg btn-square rounded-pill" wire:click.prevent="addAppointment">
                    <span class="btn-icon icofont-stethoscope-alt"></span>
                </button>
            </div>
            @endif
        </div>
    </div>

    <!-- Add appointment modals -->
    <div class="modal fade" id="modal-appointment" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @if($showEditModal)
                        <span>Edit Appointment</span>
                        @else
                        <span>Add New Appointment</span>
                        @endif
                    </h5>
                </div>
                <form autocomplete="off"
                    wire:submit.prevent="{{ $showEditModal ? 'updateAppointment' : 'createAppointment' }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <select class="form-control @error('condition_id') is-invalid @enderror"
                                wire:model="conditionId" id="condition_id" name="condition_id">
                                <option class="d-none">Select Cause/Condition</option>
                                <option value="0">New Condition</option>
                                @foreach ($conditions as $condition)
                                <option value="{{ $condition->id }}">{{ $condition->condition }}</option>
                                @endforeach
                            </select>
                            @error('condition_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        @if ($conditionId == '0')
                        <div class="form-group">
                            <input class="form-control @error('new_condition') is-invalid @enderror" type="text"
                                wire:model.defer="state.new_condition" id="new_condition" name="new_condition"
                                placeholder="New Condition">
                            @error('new_condition')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        @endif

                        <div class="form-group">
                            <x-datepicker wire:model.defer="state.date_of_visit" id="date_of_visit"
                                :error="'date_of_visit'" :holder="'date of birth'" />
                            @error('date_of_visit')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <x-timepicker wire:model.defer="state.time_from" id="time_from" :error="'time_from'"
                                        :holder="'08:00 AM'" />
                                    @error('time_from')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <x-timepicker wire:model.defer="state.time_to" id="time_to" :error="'time_to'"
                                        :holder="'End Time (Optional)'" />
                                    @error('time_to')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-block">
                        <div class="actions justify-content-between">
                            <button type="button" class="btn btn-error" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-info">
                                @if($showEditModal)
                                <span>Save Changes</span>
                                @else
                                <span>Save</span>
                                @endif
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end Add appointment modals -->
</div>


@push('scripts')
<script>
    $(document).ready(function() {
        toastr.options = {
            "positionClass": "toast-bottom-right",
            "progressBar": true,
        }

        window.addEventListener('hide-appointment-modal', event => {
            $('#modal-appointment').modal('hide');
            toastr.success(event.detail.message, 'Success!');
        })
    });
</script>
<script>
    window.addEventListener('show-appointment-modal', event => {
        $('#modal-appointment').modal('show');
    })

    window.addEventListener('show-delete-modal', event => {
        $('#confirmationModal').modal('show');
    })

    window.addEventListener('hide-delete-modal', event => {
        $('#confirmationModal').modal('hide');
        toastr.success(event.detail.message, 'Success!');
    })

        // window.addEventListener('hide-appointment-modal', event => {
        //     $('#add-admin').modal('hide');
        // })
</script>
@endpush
