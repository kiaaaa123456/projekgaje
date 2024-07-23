<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hrm\Attendance\DutySchedule;

class DutyScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $input = session()->get('input');
        $company_id = $input['company_id'] ?? 1;
        $shift_id = $input['shift_id'] ?? 1;
        $branch_id = $input['branch_id'] ?? 1;

        // Create a new DutySchedule instance
        $duty_schedule = new DutySchedule;
        $duty_schedule->company_id = $company_id;
        $duty_schedule->branch_id = $branch_id;
        $duty_schedule->shift_id = $shift_id;
        $duty_schedule->start_time = '09:00:00';
        $duty_schedule->end_time = '17:00:00';
        $duty_schedule->consider_time = '15';
        $duty_schedule->hour = '8';
        $duty_schedule->status_id = 1;
        $duty_schedule->save();
    }
}
