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
    public $subState = [];
    public $fMessage = '';
    public $sMessage = '';
    public $subMessage = '';


    public function sendMessage()
    {
        $this->sMessage = '';
        $this->fMessage = '';

        // dd($this->state);
        Validator::make($this->state, [
            'name' => 'required',
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ])->validate();


        $newContacts = ContactUs::create($this->state);

        if ($newContacts->id > 0) {
            $details = [
                'name' => $newContacts->name,
                'email' => 'info@afyatime.com',
                'subject' => $newContacts->subject,
                'msg' => 'From: ' . $newContacts->name . ' email: ' . $newContacts->email . ' phone: ' . $newContacts->phone_number . ' -- ' . $newContacts->message,
            ];
            EmailNotificationJob::dispatch($details);
            $this->reset('state');
            $this->sMessage = 'Email sent Successfull';
        } else {
            $this->fMessage = 'Fail to send email';
        }
    }

    public function subscribe()
    {
        Validator::make($this->subState, [
            'email' => 'required|email',
        ])->validate();

        // dd('Okay!');
        $newContacts = ContactUs::create($this->subState);

        if ($newContacts->id > 0) {
            $this->reset('subState');
            $this->subMessage = 'Thank you for subscribing!';
        }
    }

    public function render()
    {
        $orgTypes = OrganizationType::all();
        return view('livewire.home', compact('orgTypes'))->layout('layouts.landing');
    }
}
