<?php

namespace App\Http\Livewire;

use App\Models\UserLog;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class PrescriberTimeline extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $prescriberId;

    public function mount($id = 'prescriber')
    {
        $presc = DB::table('prescribers')->select('id')->where('prescriber_code', $id)->first();
        $this->prescriberId = $presc->id;
    }
    public function render()
    {

        $userLogs = UserLog::query()->where('prescriber_id', $this->prescriberId)->latest()->paginate(25);

        return view('livewire.prescriber-timeline', compact(['userLogs']))->layout('layouts.base');
    }
}
