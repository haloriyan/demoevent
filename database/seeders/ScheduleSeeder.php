<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'title' => "8 Oktober",
                'description' => "-",
                'date' => "2026-10-08",
                'rundowns' => [
                    [
                        'title' => "",
                    ]
                ]
            ],
            [
                'title' => "9 Oktober",
                'description' => "-",
                'date' => "2026-10-09",
                'rundowns' => [
                    [
                        'title' => "",
                    ]
                ]
            ],
            [
                'title' => "10 Oktober",
                'description' => "-",
                'date' => "2026-10-10",
                'rundowns' => [
                    [
                        'title' => "",
                    ]
                ]
            ],
        ];

        foreach ($datas as $sched) {
            $schedule = Schedule::create($sched);
        }

        DB::table('schedules')->insert($datas);
    }
}
