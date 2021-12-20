<div class="content">
    <div>

        <h2 class="content-heading">Prescriber's Type </h2>
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">All Types Used</h3>
            </div>
            <div class="block-content">
                <table class="table table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th style="width: 100px;">Initial(s)</th>
                            <th>Type's Name</th>
                            <th class="d-none d-sm-table-cell text-center" style="width: 35%;">Organization Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (sizeof($prescriberTypes)>0)
                        @foreach ($prescriberTypes as $prescriberType)
                        <tr>
                            <td style="width: 100px;">
                                <span class="font-weight-bold">
                                    {{ $prescriberType->initial ?? '' }}
                                </span>
                            </td>
                            <td class="font-w600" width="35%">
                                {{ $prescriberType->title }}
                            </td>
                            <td class="d-none d-sm-table-cell text-center" width="35%">
                                {{ $prescriberType->organization->name ?? 'System' }}
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr class="mb-15">
                            <td colspan="6" class="text-center">
                                No Type Found
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="float-right">
            {{ $prescriberTypes->links('vendor.livewire.bootstrap') }}
        </div>
    </div>
</div>
