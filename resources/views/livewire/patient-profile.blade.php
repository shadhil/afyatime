<div>
    <div class="main-content-wrap">
        <div class="page-content">

            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="card bg-light personal-info-card">
                        <img src="../assets/content/user-profile.jpg" class="card-img-top" alt="">

                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3 user-actions">
                                <img src="{{ $patient->photo == null ? asset('assets/img/default-profile.png') : Storage::disk('profiles')->url($patient->photo) }}"
                                    width="100" height="100" alt="" class="rounded-500 mr-4">

                                {{-- <button type="button" class="btn btn-danger rounded-500">Subscribe</button> --}}
                            </div>


                            <p class="text-muted">{{ $patient->first_name }} {{ $patient->last_name }}</p>

                            <h6 class="mt-0 mb-0">Address</h6>
                            <p>{{ $patient->location }} - {{ $patient->district }}, {{ $patient->region }}</p>
                            <h6 class="mt-0 mb-0">Email</h6>
                            <p>{{ $patient->email }}</p>
                            <h6 class="mt-0 mb-0">Phone</h6>
                            <p>{{ $patient->phone_number }}</p>

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
                                    <tr>
                                        <td class="text-muted">18 Feb 2019</td>
                                        <td class="text-right"><span class="badge badge-success rounded-0">$155</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">17 Feb 2019</td>
                                        <td class="text-right"><span class="badge badge-success rounded-0">$365</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">17 Feb 2019</td>
                                        <td class="text-right"><span class="badge badge-success rounded-0">$234</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">16 Feb 2019</td>
                                        <td class="text-right"><span class="badge badge-success rounded-0">$190</span>
                                        </td>
                                    </tr>
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
                                        <th scope="col">Prescribers</th>
                                        <th scope="col" class="text-right">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="assets/content/user-40-1.jpg" alt="" width="40" height="40"
                                                    class="rounded-500 mr-3">
                                                <strong>Liam</strong>
                                            </div>
                                        </td>
                                        <td class="text-right text-muted">18 Feb 2019</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="assets/content/user-40-2.jpg" alt="" width="40" height="40"
                                                    class="rounded-500 mr-3">
                                                <strong>Emma</strong>
                                            </div>
                                        </td>
                                        <td class="text-right text-muted">17 Feb 2019</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="assets/content/user-40-3.jpg" alt="" width="40" height="40"
                                                    class="rounded-500 mr-3">
                                                <strong>Olivia</strong>
                                            </div>
                                        </td>
                                        <td class="text-right text-muted">17 Feb 2019</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="assets/content/user-40-4.jpg" alt="" width="40" height="40"
                                                    class="rounded-500 mr-3">
                                                <strong>Ava</strong>
                                            </div>
                                        </td>
                                        <td class="text-right text-muted">16 Feb 2019</td>
                                    </tr>
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
                                        <tr>
                                            <td align="center">
                                                <strong>10 Feb 2018</strong>
                                            </td>
                                            <td align="center">
                                                <div class="text-muted text-nowrap">0712 789100</div>
                                            </td>
                                            <td align="center">
                                                <div class="text-muted text-nowrap">10 Feb 2018</div>
                                            </td>
                                            <td align="center">
                                                <div class="text-muted text-nowrap">9:15 - 9:45</div>
                                            </td>
                                            <td align="center">Dr. Benjamin Minja</td>
                                        </tr>
                                        <tr>
                                            <td align="center">
                                                <strong>10 Feb 2018</strong>
                                            </td>
                                            <td align="center">
                                                <div class="text-muted text-nowrap">0712 789100</div>
                                            </td>
                                            <td align="center">
                                                <div class="text-muted text-nowrap">10 Feb 2018</div>
                                            </td>
                                            <td align="center">
                                                <div class="text-muted text-nowrap">9:15 - 9:45</div>
                                            </td>
                                            <td align="center">Dr. Benjamin Minja</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="add-action-box">
                <button class="btn btn-primary btn-lg btn-square rounded-pill" data-toggle="modal"
                    data-target="#add-appointment">
                    <span class="btn-icon icofont-stethoscope-alt"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Add appointment modals -->
    <div class="modal fade" id="add-appointment" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add new appointment</h5>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group avatar-box d-flex">
                            <img src="../assets/content/anonymous-400.jpg" width="40" height="40" alt=""
                                class="rounded-500 mr-4">

                            <button class="btn btn-outline-primary" type="button">
                                Select image<span class="btn-icon icofont-ui-user ml-2"></span>
                            </button>
                        </div>

                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Name">
                        </div>

                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Doctor">
                        </div>

                        <div class="form-group">
                            <input class="form-control" type="email" placeholder="Email">
                        </div>

                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Date">
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <input class="form-control" type="text" placeholder="Time from">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <input class="form-control" type="text" placeholder="Time to">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <input class="form-control" type="number" placeholder="Number">
                        </div>

                        <div class="form-group mb-0">
                            <input class="form-control" type="text" placeholder="Injure">
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-block">
                    <div class="actions justify-content-between">
                        <button type="button" class="btn btn-error" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-info">Add appointment</button>
                    </div>
                </div>
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
