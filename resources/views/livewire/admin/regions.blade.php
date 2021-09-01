<div class="main-content-wrap">
    <header class="page-header">
        <h1 class="page-title">Regions</h1>
    </header>

    <div class="page-content">
        <div class="row">
            @foreach ($regions as $region)
            <div class="col-12 col-md-4">
                <div class="contact">
                    <div class="info-box">
                        <h4 class="name"><a
                                href="{{ route('admin.regions.district', $region->id) }}">{{ $region->name }}</a></h4>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- <div class="add-action-box">
            <button class="btn btn-dark btn-lg btn-square rounded-pill" data-toggle="modal" data-target="#add-doctor">
                <span class="btn-icon icofont-contact-add"></span>
            </button>
        </div> --}}
    </div>
</div>
