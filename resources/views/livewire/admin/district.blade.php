<div class="content">
    <h2 class="content-heading">{{ $region->name }}</h2>
    <div class="block-header">
        <h3 class="block-title">All Districts</h3>
    </div>
    @if (sizeof($districts)>0)
    <div class="row">
        @foreach ($districts as $district)
        <div class="col-md-6 col-xl-4">
            <a class="block block-link-shadow" href="javascript:void(0)">
                <div class="block-content block-content-full clearfix">
                    <div class="float-left mt-10">
                        <div class="font-w600 mb-5">{{ $district->name }}</div>
                        <div class="font-size-sm text-muted">{{ $district->organizations()->count() }} Organization(s)
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
            No District Found
        </div>
    </div>
    @endif
</div>
