<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


class FindUsersByTime extends Command
{
    protected $signature = 'users:check-time {serverTimezone} {serverTime}';
    protected $description = 'Check users time';

    public function handle()
    {
        $serverTimezone = $this->argument('serverTimezone');
        $serverTime = Carbon::createFromFormat('H:i', $this->argument('serverTime'));

        $users = User::all();

        $timezoneMap = [
            'UTC' => 'UTC',
            'UTC+1' => 'Europe/Berlin',
            'UTC+2' => 'Europe/Moscow',
            'UTC+3' => 'Europe/Istanbul',
            'UTC+4' => 'Asia/Dubai',
            'UTC+5' => 'Asia/Karachi',
            'UTC+6' => 'Asia/Dhaka',
            'UTC+7' => 'Asia/Bangkok',
            'UTC+8' => 'Asia/Shanghai',
            'UTC+9' => 'Asia/Tokyo',
            'UTC+10' => 'Australia/Sydney',
            'UTC+11' => 'Asia/Magadan',
            'UTC+12' => 'Pacific/Fiji',
        ];

        foreach ($users as $user) {
            if ($user->timezone === null) {
                $this->error("User {$user->name} has no timezone set.");
                continue;
            }

            if (!isset($timezoneMap[$user->timezone])) {
                $this->error("Unknown timezone for user {$user->name}: {$user->timezone}");
                continue;
            }

            $userTimezone = $timezoneMap[$user->timezone];
            $userTime = $serverTime->copy()->setTimezone($userTimezone);

            if ($userTime->format('H:i') === '05:50') {
                $this->info("User: {$user->name}, Timezone: {$user->timezone}");
            }
        }
    }
}
