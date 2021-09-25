<div>
    <div class="main-content-wrap">
        <div class="page-content">
            <div class="row">
                <div class="col col-12 col-md-6 col-xl-3">
                    <div class="card animated fadeInUp delay-01s bg-light">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col col-5">
                                    <div class="icon p-0 fs-48 text-primary opacity-50 icofont-first-aid-alt">
                                    </div>
                                </div>

                                <div class="col col-7">
                                    <h6 class="mt-0 mb-1">Appointments</h6>
                                    <div class="count text-primary fs-20">{{ $org->appointments()->count() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col col-12 col-md-6 col-xl-3">
                    <div class="card animated fadeInUp delay-02s bg-light">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col col-5">
                                    <div class="icon p-0 fs-48 text-primary opacity-50 icofont-wheelchair">
                                    </div>
                                </div>

                                <div class="col col-7">
                                    <h6 class="mt-0 mb-1">Patients</h6>
                                    <div class="count text-primary fs-20">{{ $org->patients()->count() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col col-12 col-md-6 col-xl-3">
                    <div class="card animated fadeInUp delay-03s bg-light">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col col-5">
                                    <div class="icon p-0 fs-48 text-primary opacity-50 icofont-blood"></div>
                                </div>

                                <div class="col col-7">
                                    <h6 class="mt-0 mb-1">Prescribers</h6>
                                    <div class="count text-primary fs-20">{{ $org->prescribers()->count() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col col-12 col-md-6 col-xl-3">
                    <div class="card animated fadeInUp delay-04s bg-light">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col col-5">
                                    <div class="icon p-0 fs-48 text-primary opacity-50 icofont-dollar-true">
                                    </div>
                                </div>

                                <div class="col col-7">
                                    <h6 class="mt-0 mb-1 text-nowrap"> Supporters</h6>
                                    <div class="count text-primary fs-20">{{ $org->supporters()->count() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-header">
                            {{ $org->name }}
                        </div>
                        <div class="card-body">
                            <h6 class="mt-0 mb-0">Address</h6>
                            <p>{{ $org->location }} - {{ $org->district->name }}, {{ $org->district->region->name }}</p>
                            <h6 class="mt-0 mb-0">Email</h6>
                            <p>{{ $org->email }}</p>
                            <h6 class="mt-0 mb-0">Phone</h6>
                            <p>{{ $org->phone_number }}</p>

                            @if (!empty($subscription->status))
                            @if (Auth::user()->isAdmin())
                            @if ($subscription->status == \App\Models\OrganizationSubscription::PAID)
                            <button class="btn btn-secondary">
                                Waiting Confirmation<span class="btn-icon icofont-question-circle ml-2"></span>
                            </button>
                            @elseif ($subscription->status == \App\Models\OrganizationSubscription::SUBSCRIBED)
                            <button class="btn btn-outline-light" wire:click="addSubscription">
                                Due Date - {{ $subscription->end_date }}<span
                                    class="btn-icon icofont-check-circled ml-2"></span>
                            </button>
                            @elseif ($subscription->status == \App\Models\OrganizationSubscription::UNSUBSCRIBED ||
                            empty($subscription->status))
                            <button class="btn btn-warning" wire:click="addSubscription">
                                UnSubscribed<span class="btn-icon icofont-lock ml-2"></span>
                            </button>
                            @elseif ($subscription->status == \App\Models\OrganizationSubscription::BLOCKED)
                            <button class=" btn btn-danger">
                                Blocked<span class="btn-icon icofont-ban ml-2"></span>
                            </button>
                            @endif
                            @endif
                            @endif
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            Latest Patients
                        </div>
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Patient</th>
                                        <th scope="col" class="text-right">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($patients as $patient)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $patient->photo == null ? asset('assets/img/default-profile.png') : Storage::disk('profiles')->url($patient->photo) }}"
                                                    alt="" width="40" height="40" class="rounded-500 mr-3">
                                                <strong>{{ $patient->first_name }} {{ $patient->last_name }}</strong>
                                            </div>
                                        </td>
                                        <td class="text-right text-muted">
                                            {{ \Carbon\Carbon::parse($patient->created_at)->format('d/m/Y') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card mb-md-0">
                        <div class="card-header">
                            Top Supporters
                        </div>
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col" class="text-center">Patient(s)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($supporters as $supporter)
                                    <tr>
                                        <td class="text-muted">{{ $supporter->full_name }}</td>
                                        <td class="text-center"><span
                                                class="badge badge-success rounded-0">{{ $supporter->patients()->count() }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-8">
                    <div class="card mb-0">
                        <div class="card-header">
                            Latest Appointments
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Photo</th>
                                            <th scope="col" class="text-center">Name</th>
                                            {{-- <th scope="col" class="text-center">Phone</th> --}}
                                            <th scope="col" class="text-center">Visit Date</th>
                                            <th scope="col" class="text-center"> Time</th>
                                            <th scope="col" class="text-center">Prescriber</th>
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
                                            <td align="center">
                                                <strong>{{ $appointment->patient->first_name }}
                                                    {{ $appointment->patient->last_name }}</strong>
                                            </td>

                                            <td align="center">
                                                <div class="text-muted text-nowrap">
                                                    {{ \Carbon\Carbon::parse($appointment->date_of_visit)->format('d/m/Y')  }}
                                                </div>
                                            </td>
                                            <td align="center">
                                                <div class="text-muted text-nowrap">
                                                    {{ \Carbon\Carbon::parse($appointment->visit_time)->format('h:i A') }}
                                                </div>
                                            </td>
                                            <td align="center">
                                                {{ $appointment->prescriber->prescriber_type->initial ?? '' }}
                                                {{ $appointment->prescriber->first_name }}
                                                {{ $appointment->prescriber->last_name }}</td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="6" align="center">No Appointment Found</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add appointment modals -->
    <div class="modal fade" id="modal-subscription" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @if($showEditModal)
                        <span>Edit Appointment</span>
                        @else
                        <span>Add New Subscription</span>
                        @endif
                    </h5>
                </div>
                <form autocomplete="off"
                    wire:submit.prevent="{{ $showEditModal ? 'updateSubscription' : 'createSubscription' }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <select class="form-control @error('package_id') is-invalid @enderror"
                                wire:model.defer="state.package_id" id="package_id" name="package_id">
                                <option class="d-none">Select Package</option>
                                @foreach ($packages as $package)
                                <option value="{{ $package->id }}">{{ $package->name }}
                                    {{ ' - @ TSh. '.$package->monthly_cost }}</option>
                                @endforeach
                            </select>
                            @error('package_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input class="form-control @error('payment_ref') is-invalid @enderror" type="text"
                                wire:model.defer="state.payment_ref" id="payment_ref" name="payment_ref"
                                placeholder="Payment Reference">
                            @error('payment_ref')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input class="form-control @error('total_price') is-invalid @enderror" type="text"
                                wire:model.defer="state.total_price" id="total_price" name="total_price"
                                placeholder="Total Price">
                            @error('total_price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
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
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/icofont.min.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/js/jquery.barrating.min.js') }}"></script>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        toastr.options = {
            "positionClass": "toast-bottom-right",
            "progressBar": true,
        }

        window.addEventListener('hide-subscription-modal', event => {
            $('#modal-subscription').modal('hide');
            toastr.success(event.detail.message, 'Success!');
        })
    });
</script>
<script>
    window.addEventListener('show-subscription-modal', event => {
        $('#modal-subscription').modal('show');
    })

    window.addEventListener('show-delete-modal', event => {
        $('#delete-modal').modal('show');
    })

    window.addEventListener('hide-delete-modal', event => {
        $('#delete-modal').modal('hide');
        toastr.success(event.detail.message, 'Success!');
    })

</script>
@endpush
