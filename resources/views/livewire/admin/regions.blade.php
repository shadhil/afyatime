<div class="content">
    <h2 class="content-heading">Tanzania</h2>
    <div class="block-header">
        <h3 class="block-title">All Regions</h3>
    </div>
    @if (sizeof($regions)>0)
    <div class="row">
        @foreach ($regions as $region)
        <div class="col-md-6 col-xl-4">
            <a class="block block-link-shadow" href="{{ route('admin.regions.district', $region->id) }}">
                <div class="block-content block-content-full clearfix">
                    <div class="float-left mt-10">
                        <div class="font-w600 mb-5">{{ $region->name }}</div>
                        <div class="font-size-sm text-muted">{{ $region->districts()->count() }} District(s)
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    @else
    <div class="row mb-15">
        <div class="col-sm-12 col-xl-12 text-center">
            No Regions Found
        </div>
    </div>
    @endif

</div>
