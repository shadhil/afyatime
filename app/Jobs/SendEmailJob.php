<?php

namespace App\Jobs;

use App\Mail\Gmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = "shadhil90@gmail.com";
        $details = [
            'title' => 'First Time for Everything',
            'body' => 'I am Kingsley Okpara, a Python and PHP Fullstack Web developer and tech writer, I also have extensive knowledge and experience with JavaScript while working on applications developed with VueJs.'
        ];
        Mail::to($email)->send(new Gmail($details));
    }
}
