<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class FindUsersByTime extends Command
{
    protected $signature = 'users:find-by-time';
    protected $description = 'Find users by time';

    public function handle()
    {
        $serverTime = Carbon::now('UTC');
        $serverTimezone = 'UTC';

        $users = User::all();

        foreach ($users as $user) {
            $this->info($user->name . ' (' . $user->timezone . ')');
        }
    }
}
