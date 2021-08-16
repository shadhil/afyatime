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
                                <tr>
                                    <td>
                                        <img src="../assets/content/user-40-1.jpg" alt="" width="40" height="40"
                                            class="rounded-500">
                                    </td>
                                    <td>
                                        <strong>Liam</strong>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center nowrap text-primary">
                                            <span class="icofont-ui-email p-0 mr-2"></span>
                                            liam@gmail.com
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-muted text-nowrap">10 Feb 2018</div>
                                    </td>
                                    <td>
                                        <div class="text-muted text-nowrap">9:15 - 9:45</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center nowrap text-primary">
                                            <span class="icofont-ui-cell-phone p-0 mr-2"></span>
                                            0126595743
                                        </div>
                                    </td>
                                    <td>Dr. Benjamin</td>
                                    <td>mumps</td>
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
                            </tbody>
                        </table>
                    </div>

                    <nav class="mt-4">
                        <ul class="pagination">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" aria-label="Previous" tabindex="-1" aria-disabled="true">
                                    <span class="icofont-simple-left"></span>
                                </a>
                            </li>
                            <li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span class="icofont-simple-right"></span>
                                </a>
                            </li>
                        </ul>
                    </nav>
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
