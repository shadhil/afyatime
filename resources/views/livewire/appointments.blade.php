<div>

    <h2 class="content-heading">Appointments </h2>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">All Patients</h3>
        </div>
        <div class="block-content">
            <p>The second way is to use <a href="be_ui_grid.html#cb-grid-rutil">responsive utility CSS classes</a> for
                hiding columns in various screen resolutions. This way you can hide less important columns and keep the
                most
                valuable on smaller screens. At the following example the <strong>Access</strong> column isn't visible
                on
                small and extra small screens and <strong>Email</strong> column isn't visible on extra small screens.
            </p>
            <table class="table table-striped table-vcenter">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 100px;"><i class="si si-user"></i></th>
                        <th>Patient's Name</th>
                        <th class="d-none d-sm-table-cell" style="width: 20%;">Date & Time</th>
                        <th class="d-none d-md-table-cell" style="width: 20%;">Prescriber</th>
                        <th class="d-none d-md-table-cell" style="width: 10%;">Reminder</th>
                        <th class="text-center" style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if (sizeof($appointments)>0)
                    @foreach ($appointments as $appointment)
                    <tr>
                        <td class="text-center">
                            <img class="img-avatar img-avatar48"
                                src="{{ $appointment->patient->photo == null ? asset('assets/img/default-profile.png') : Storage::disk('profiles')->url($appointment->patient->photo) }}"
                                alt="">
                        </td>
                        <td class="font-w600"> <a href="{{ route('patient-profile', $appointment->patient->id) }}"> {{
                                $appointment->patient->first_name }}
                                {{ $appointment->patient->last_name }} </a> </td>
                        <td class="d-none d-sm-table-cell">Tomorrow at {{
                            \Carbon\Carbon::parse($appointment->visit_time)->format('h:i') }}</td>
                        <td class="d-none d-md-table-cell">
                            {{ $appointment->prescriber->prescriber_type->initial ?? '' }}
                            {{ $appointment->prescriber->first_name }}
                            {{ $appointment->prescriber->last_name }}
                        </td>
                        <td class="d-none d-md-table-cell">
                            <span
                                class="badge {{ ($appointment->app_type == 'weekly') ? 'badge-primary' : 'badge-danger'}}">
                                {{ Str::upper($appointment->app_type) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip"
                                    title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip"
                                    title="Delete">
                                    <i class="fa fa-times"></i>
                                </button>
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
    </div>

</div>
