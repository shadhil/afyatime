<div>
    <div class="main-content-wrap">

        <div class="page-content">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="contact">
                        <div class="info-box">
                            <h4 class="name">{{ $item->title }} - {{ $item->id }} </h4>
                            <p class="address">{{ $item->dueDate }}</p>
                            <div class="button-box">
                                <a href="doctor.html" class="btn btn-primary">View profile</a>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- @if (sizeof($items)>0)
                @foreach ($items as $item)
                <div class="col-12 col-md-12">
                    <div class="contact">
                        <div class="info-box">
                            <h4 class="name">{{ $item->title }} </h4>
                <p class="address">{{ $item->dueDate }}</p>
                <div class="button-box">
                    <a href="doctor.html" class="btn btn-primary">View profile</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @else
    <div class="col-md-12">
        <div class="contact">
            <div class="info-box">
                <p class="address">No Prescriber found</p>
            </div>
        </div>
    </div>
    @endif --}}
</div>
</div>
</div>

</div>
