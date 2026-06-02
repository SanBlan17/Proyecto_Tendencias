<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Schedule;
use Carbon\Carbon;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $startDate = Carbon::parse('2026-06-15');

        for ($i = 0; $i < 15; $i++) {

            Schedule::create([
                'barber_id' => 1,
                'work_date' => $startDate->copy()->addDays($i),
                'start_time' => '08:00:00',
                'end_time' => '17:00:00',
                'is_available' => true
            ]);
        }
    }
}
