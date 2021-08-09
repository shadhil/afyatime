<div class="main-content-wrap">
    <header class="page-header">
        <h1 class="page-title">Organizations</h1>
    </header>

    <div class="page-content">
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="card department bg-light bg-gradient">
                    <img src="../assets/content/department-1.jpg" class="card-img-top" width="400" height="250" alt="">

                    <div class="card-body">
                        <h3 class="h4 mt-0">Cardiology</h3>

                        <div class="team d-flex align-items-center mb-4">
                            <strong class="mr-3">Team:</strong>

                            <img src="../assets/content/doctor-400-1.jpg" width="40" height="40" alt=""
                                class="team-img rounded-500">
                            <img src="../assets/content/doctor-400-2.jpg" width="40" height="40" alt=""
                                class="team-img rounded-500">
                            <img src="../assets/content/doctor-400-3.jpg" width="40" height="40" alt=""
                                class="team-img rounded-500">
                            <button class="btn btn-primary btn-square rounded-pill" type="button">
                                <span class="btn-icon icofont-plus"></span>
                            </button>
                        </div>

                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio dolore enim, nemo nihil
                            non omnis temporibus? Blanditiis culpa labore velit.</p>

                        <div class="button-box pb-2">
                            <button type="button" class="btn btn-outline-primary">
                                More<span class="btn-icon icofont-prescription ml-2"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card department bg-light bg-gradient">
                    <img src="../assets/content/department-2.jpg" class="card-img-top" width="400" height="250" alt="">

                    <div class="card-body">
                        <h3 class="h4 mt-0">Dentistry</h3>

                        <div class="team d-flex align-items-center mb-4">
                            <strong class="mr-3">Prescribers:</strong>

                            <img src="../assets/content/doctor-400-4.jpg" width="40" height="40" alt=""
                                class="team-img rounded-500">
                            <img src="../assets/content/doctor-400-2.jpg" width="40" height="40" alt=""
                                class="team-img rounded-500">
                            <img src="../assets/content/doctor-400-3.jpg" width="40" height="40" alt=""
                                class="team-img rounded-500">
                            <img src="../assets/content/doctor-400-5.jpg" width="40" height="40" alt=""
                                class="team-img rounded-500">

                        </div>

                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio dolore enim, nemo nihil
                            non omnis temporibus? Blanditiis culpa labore velit.</p>

                        <div class="button-box pb-2">
                            <button type="button" class="btn btn-outline-primary">
                                More<span class="btn-icon icofont-prescription ml-2"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card department bg-light bg-gradient">
                    <img src="../assets/content/department-3.jpg" class="card-img-top" width="400" height="250" alt="">

                    <div class="card-body">
                        <h3 class="h4 mt-0">Laboratory</h3>

                        <div class="team d-flex align-items-center mb-4">
                            <strong class="mr-3">Team:</strong>

                            <img src="../assets/content/doctor-400-6.jpg" width="40" height="40" alt=""
                                class="team-img rounded-500">
                            <img src="../assets/content/doctor-400-7.jpg" width="40" height="40" alt=""
                                class="team-img rounded-500">

                        </div>

                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio dolore enim, nemo nihil
                            non omnis temporibus? Blanditiis culpa labore velit.</p>

                        <div class="button-box pb-2">
                            <button type="button" class="btn btn-outline-primary">
                                More<span class="btn-icon icofont-prescription ml-2"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="add-action-box">
            <button class="btn btn-primary btn-lg btn-square rounded-pill" data-toggle="modal"
                data-target="#add-organization">
                <span class="btn-icon icofont-plus"></span>
            </button>
        </div>
    </div>
</div>

@push('models')
<!-- Add appointment modals -->
<div class="modal fade" id="add-organization" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Organization</h5>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group avatar-box d-flex">
                        <img src="{{ asset('assets/content/anonymous-400.jpg') }}" width="40" height="40" alt=""
                            class="rounded-500 mr-4">

                        <input class="btn btn-outline-primary" type="file" accept="image/*">
                    </div>

                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Title">
                    </div>

                    <div class="form-group">
                        <textarea class="form-control" placeholder="Descriptions" rows="3"></textarea>
                    </div>

                    <div>
                        <label>Employees</label>

                        <div class="social-list">
                            <div class="social-item">
                                <div class="row">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col-12 col-sm-6">
                                                <div class="form-group">
                                                    <div class="prefix-icon"></div>
                                                    <input class="form-control" type="text" placeholder="Icon class"
                                                        value="Dr. Sophie" readonly>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                <div class="form-group">
                                                    <input class="form-control" type="text" placeholder="Link"
                                                        value="assets/content/doctor-1.jpg">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col col-auto">
                                        <button class="btn btn-outline-danger btn-square rounded-pill" type="button">
                                            <span class="btn-icon icofont-ui-delete"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="social-item">
                                <div class="row">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col-12 col-sm-6">
                                                <div class="form-group">
                                                    <input class="form-control" type="text" placeholder="Icon class"
                                                        value="Dr. Liam" readonly>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                <div class="form-group">
                                                    <input class="form-control" type="text" placeholder="Link"
                                                        value="assets/content/doctor-2.jpg">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col col-auto">
                                        <button class="btn btn-outline-danger btn-square rounded-pill" type="button">
                                            <span class="btn-icon icofont-ui-delete"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="mt-0">

                        <label>Add employee</label>

                        <div class="social-list">
                            <div class="social-item">
                                <div class="row">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col-12 col-sm-6">
                                                <div class="form-group mb-sm-0">
                                                    <input class="form-control" type="text" placeholder="Doctor name">
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                <div class="form-group mb-0">
                                                    <input class="form-control" type="text" placeholder="Doctor image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col col-auto">
                                        <button class="btn btn-outline-primary btn-square rounded-pill" type="button">
                                            <span class="btn-icon icofont-plus"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-block">
                <div class="actions justify-content-between">
                    <button type="button" class="btn btn-error" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-info">Add department</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end Add appointment modals -->
{{-- <link rel="stylesheet" href="{{ asset('assets/css/icofont.min.css') }}"> --}}
@endpush

@push('scripts')
<script src="{{ asset('assets/js/jquery.barrating.min.js') }}"></script>
@endpush
