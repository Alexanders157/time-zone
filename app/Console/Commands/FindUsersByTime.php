<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


class FindUsersByTime extends Command
{
    protected $signature = 'users:by-time {server-timezone} {server-time}';
    protected $description = 'Find users by their local time';

    public function handle()
    {
        $serverTimezone = $this->argument('server-timezone');
        $serverTime = $this->argument('server-time');

        $serverTime = Carbon::parse($serverTime, $serverTimezone);

        $users = DB::table('users')
            ->whereRaw("CONVERT_TZ('$serverTime', '$serverTimezone', timezone) = '05:50:00'")
            ->get();

        foreach ($users as $user) {
            $this->info("User: {$user->name}, Timezone: {$user->timezone}");
        }
    }
}
