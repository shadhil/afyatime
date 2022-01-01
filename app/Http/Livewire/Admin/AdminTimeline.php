<?php

namespace App\Http\Livewire\Admin;

use App\Models\AdminLog;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AdminTimeline extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $prescriberId;

    public function render()
    {

        $adminLogs = AdminLog::query()->latest()->paginate(25);

        return view('livewire.admin.admin-timeline', compact(['adminLogs']))->layout('layouts.admin-base');
    }
}
