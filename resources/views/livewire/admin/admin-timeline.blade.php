<div>
    <div class="row">

        <!-- Updates -->
        <div class="col-lg-12 col-xl-12">
            <div class="block block-rounded block-bordered">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Admin's Timeline</h3>
                    {{-- <div class="block-options">
                        <a href="{{ route('appointments') }}" type="button" class="btn btn-alt-primary">
                            <i class="fa fa-calendar mr-5"></i>All Events
                        </a>
                    </div> --}}
                </div>
                <div class="block-content block-content-full">
                    <div class="table-responsive">
                        <table class="table table-borderless table-hover table-striped table-vcenter mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center">Admin's Name</th>
                                    <th width="10%" class="text-center">Date</th>
                                    <th width="10%" class="text-center">Time</th>
                                    <th width="25%" class="d-none d-sm-table-cell text-center">Action</th>
                                    <th class="d-none d-md-table-cell text-center">Entity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (sizeof($adminLogs)>0)
                                @php
                                $actionDate = '';
                                @endphp
                                @foreach ($adminLogs as $userLog)
                                @php
                                $currentDate = \Carbon\Carbon::parse($userLog->created_at)->format('d/m/Y');
                                if ($actionDate == $currentDate) {
                                $currentDate = '" "';
                                } else {
                                $actionDate = $currentDate;
                                }
                                @endphp
                                <tr>
                                    <td class="text-center">
                                        {{ $userLog->admin->name }}
                                    </td>
                                    <td width="20%" class="text-center">
                                        {{ $currentDate }}
                                    </td>
                                    <td width="10%" class="text-center">
                                        {{ \Carbon\Carbon::parse($userLog->created_at)->format('h:i A') }}
                                    </td>
                                    <td class="d-none d-sm-table-cell text-center">
                                        <span class="badge badge-secondary">
                                            {{ $userLog->userAction->action }}
                                        </span>
                                    </td>
                                    <td class="d-none d-md-table-cell text-center">
                                        <span class="">
                                            @if ($userLog->entity_type == 'prescriber_type')
                                            {{ $userLog->entity->id ?? '' }} - {{ $userLog->entity->title ?? '' }} {{
                                            $userLog->note ?? '' }}
                                            @elseif ($userLog->entity_type == 'prescriber')
                                            {{ $userLog->entity->id ?? '' }} - {{ $userLog->entity->first_name ?? '' }}
                                            {{ $userLog->entity->last_name ?? '' }}
                                            @elseif ($userLog->entity_type == 'patient')
                                            {{ $userLog->entity->id ?? '' }} - {{ $userLog->entity->first_name ?? '' }}
                                            {{ $userLog->entity->last_name ?? '' }}
                                            @elseif ($userLog->entity_type == 'appointment')
                                            {{ $userLog->entity->id ?? '' }} - {{ $userLog->entity->patient->first_name
                                            ?? '' }} {{ $userLog->entity->patient->last_name ?? '' }} {{
                                            $userLog->note ?? '' }}
                                            @elseif ($userLog->entity_type == 'supporter')
                                            {{ $userLog->entity->id ?? '' }} - {{
                                            $userLog->entity->full_name
                                            ?? '' }} {{
                                            $userLog->note ?? '' }}
                                            @elseif ($userLog->entity_type == 'organization')
                                            {{ $userLog->entity->id ?? '' }} - {{
                                            $userLog->entity->name
                                            ?? '' }} {{
                                            $userLog->note ?? '' }}
                                            @elseif ($userLog->entity_type == 'orgSubscription')
                                            {{ $userLog->entity->id ?? '' }} - {{
                                            $userLog->entity->organization->name
                                            ?? '' }} {{
                                            $userLog->note ?? '' }}
                                            @elseif ($userLog->entity_type == 'user')
                                            {{ $userLog->entity->id ?? '' }} - {{
                                            $userLog->entity->name
                                            ?? '' }} {{
                                            $userLog->note ?? '' }}
                                            @else
                                            {{ $userLog->entity->id ?? '' }}
                                            @endif
                                            {{-- {{ $userLog->entity->id ?? '' }} --}}
                                        </span>
                                    </td>
                                    {{-- <td class="d-none d-md-table-cell text-center">
                                        <span
                                            class="badge {{ $appointment->app_type == 'weekly' ? 'badge-info' : 'badge-success' }}">{{
                                            $appointment->app_type }}</span>
                                    </td> --}}
                                </tr>
                                @endforeach
                                @else
                                <div class="row mb-15">
                                    <div class="col-sm-12 col-xl-12 text-center">
                                        No Events Found
                                    </div>
                                </div>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="float-right mt-0 pb-10">
                {{ $adminLogs->links('vendor.livewire.bootstrap') }}
            </div>
        </div>
        <!-- END Updates -->
    </div>

</div>
@push('scripts')
<script>

</script>
@endpush
