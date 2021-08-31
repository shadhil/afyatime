<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class ApiTests extends Component
{
    public function render()
    {
        // $response = Http::get('https://fakerestapi.azurewebsites.net/api/v1/Activities');
        // $body = json_decode($response->body());

        // $response = Http::get('https://fakerestapi.azurewebsites.net/api/v1/Activities/22');
        // $body = json_decode($response->body());

        // $response = Http::post('https://fakerestapi.azurewebsites.net/api/v1/Activities', [
        //     'title' => 'My Activity',
        //     'completed' => true,
        //     'dueDate' => Carbon::now(),
        // ]);
        // $body = json_decode($response->body());

        // $response = Http::put('https://fakerestapi.azurewebsites.net/api/v1/Activities/22', [
        //     'title' => 'My Updated Activity',
        //     'completed' => true,
        //     'dueDate' => Carbon::now(),
        // ]);
        // $body = json_decode($response->body());

        // $response = Http::get('https://fakerestapi.azurewebsites.net/api/v1/Activities');
        // $body = json_decode($response->body());

        $response = Http::withHeaders([
            'Authorization' => 'Basic c2hhenk6bXlkdXR5IzMxMTA=',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->withBody('{"from": "SENDER", "to": "255712793880", "text": "Your message"}', 'application/json')->post('https://messaging-service.co.tz/api/sms/v1/test/text/single');
        $body = json_decode($response->body());

        dd($body);
        return view('livewire.api-tests', ['item' => $body]);
    }
}
