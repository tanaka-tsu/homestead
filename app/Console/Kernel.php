<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    // protected function schedule(Schedule $schedule)
    // {
    //     $schedule->call(function () {
    //         // 全ユーザーを取得
    //         $users = User::all();

    //         foreach ($users as $user) {
    //             // 各ユーザーのKintaiレコードを作成
    //             Kintai::create([
    //                 'user_id' => $user->id,
    //                 'this_month' => Carbon::now()->startOfMonth(),
    //             ]);
    //         }
    //     })->monthlyOn(1, '00:00'); // 毎月1日の午前0時に実行
    // }
}
