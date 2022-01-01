<?php

namespace App\Http\Livewire;

use App\Jobs\EmailNotificationJob;
use App\Models\ContactUs;
use App\Models\OrganizationType;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Home extends Component
{
    public $state = [];
    public $fMessage = '';
    public $sMessage = '';


    public function contactUs()
    {
        // dd($this->state);
        Validator::make($this->state, [
            'name' => 'required',
            'organization' => 'string',
            'email' => 'required|email',
            'message' => 'required',
        ])->validate();


        $newContacts = ContactUs::create($this->state);

        if ($newContacts->id > 0) {
            $details = [
                'name' => $newContacts->name,
                'email' => 'info@afyatime.com',
                'subject' => 'New Web Contact',
                'msg' => '' . $newContacts->name . ' from ' . $newContacts->organization . ' has contact us through email known as ' . $newContacts->email . ' with this message: <br> <b>  ' . $newContacts->message . ' </b>',
            ];
            EmailNotificationJob::dispatch($details);
            $this->reset('state');
            $this->sMessage = 'Email sent Successfull';
        } else {
            $this->fMessage = 'Fail to send email';
        }
    }

    public function render()
    {
        $orgTypes = OrganizationType::all();
        return view('livewire.home', compact('orgTypes'))->layout('layouts.landing');
    }
}
