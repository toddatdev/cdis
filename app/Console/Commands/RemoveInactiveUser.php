<?php

namespace App\Console\Commands;

use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RemoveInactiveUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'removeInactiveUsers:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes inactive users from the database';

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
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        $users = User::where('is_logged_in', 1)->where('last_activity', '!=', null)->get();

        foreach ($users as $user) {
            if ($user->last_activity < Carbon::now()->subMinutes(20)->format('Y-m-d H:i:s')) {

                $user->is_logged_in = 0;
                $user->last_activity = null;
                $user->timestamps = false;
                $user->save();
            }
        }
    }
}
