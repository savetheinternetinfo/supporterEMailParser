<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\User;
use Illuminate\Support\Facades\Hash;

class createUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return abort(404);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        return User::create([
            'name' => env('ADMIN_USER_NAME'),
            'email' => env('ADMIN_USER_MAIL'),
            'password' => Hash::make(env('ADMIN_USER_PASS')),
        ]);
    }
}
