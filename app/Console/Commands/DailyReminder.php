<?php

namespace App\Console\Commands;

use App\Mail\Gmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class DailyReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Respectively send an exclusive email to everyone whose appointment day is approaching via email.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
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
