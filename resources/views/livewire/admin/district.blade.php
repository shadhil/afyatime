<div class="main-content-wrap">
    <header class="page-header">
        <h1 class="page-title">{{ $region->name }}</h1>
    </header>

    <div class="page-content">
        <div class="row">
            @foreach ($districts as $district)
            <div class="col-12 col-md-4">
                <div class="contact">
                    <div class="info-box">
                        <h4 class="name"><span href="">{{ $district->name }}</span></h4>
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
