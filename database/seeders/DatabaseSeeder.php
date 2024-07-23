<?php

use Database\Seeders\Admin\CompanySeeder;
use Database\Seeders\Admin\PermissionSeeder;
use Database\Seeders\Admin\RoleSeeder;
use Database\Seeders\Admin\StatusSeeder;
use Database\Seeders\Admin\UserSeeder;
use Database\Seeders\AttendanceSeeder;
use Database\Seeders\AwardSeeder;
use Database\Seeders\BranchSeeder;
use Database\Seeders\CompanyConfigSeeder;
use Database\Seeders\DesignationSeeder;
use Database\Seeders\DutyScheduleSeeder;
use Database\Seeders\ExpenseSeeder;
use Database\Seeders\FeatureSeeder;
use Database\Seeders\GoalSeeder;
use Database\Seeders\Hrm\AllContentSeeder;
use Database\Seeders\Hrm\AppointmentSeeder;
use Database\Seeders\Hrm\AppSetting\AppScreenSeeder;
use Database\Seeders\Hrm\Country\CountrySeeder;
use Database\Seeders\Hrm\EmployeeTasksSeeder;
use Database\Seeders\Hrm\HolidaySeeder;
use Database\Seeders\Hrm\LeaveSettingSeeder;
use Database\Seeders\Hrm\MeetingSeeder;
use Database\Seeders\Hrm\PaymentSeeder;
use Database\Seeders\Hrm\Shift\ShiftSeeder;
use Database\Seeders\Hrm\SubscriptionSeeder;
use Database\Seeders\Hrm\TeamSeeder;
use Database\Seeders\Hrm\Visit\NoteSeeder;
use Database\Seeders\Hrm\Visit\ScheduleSeeder;
use Database\Seeders\Hrm\Visit\VisitSeeder;
use Database\Seeders\IndicatorSeeder;
use Database\Seeders\LeaveSeeder;
use Database\Seeders\LocationLogsTableSeeder;
use Database\Seeders\Management\ClientSeeder;
use Database\Seeders\Management\ProjectSeeder;
use Database\Seeders\ModuleSeeder;
use Database\Seeders\NoticeSeeder;
use Database\Seeders\NotificationSeeder;
use Database\Seeders\NotificationTypeSeeder;
use Database\Seeders\PayrollSeeder;
use Database\Seeders\SettingsSeeder;
use Database\Seeders\Task\TaskSeeder;
use Database\Seeders\TestimonialSeeder;
use Database\Seeders\Traits\ApplicationKeyGenerate;
use Database\Seeders\Travel\TravelSeeder;
use Database\Seeders\UploadSeeder;
use Database\Seeders\UserDocumentRequestSeed;
use Database\Seeders\WeekendSetupSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use ApplicationKeyGenerate;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // $this->keyGenerate();
        $this->call(CountrySeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(BranchSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(DesignationSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(ShiftSeeder::class);
        // now
        $this->call(UserSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(UploadSeeder::class);
        $this->call(CompanyConfigSeeder::class);

        $this->call(LeaveSettingSeeder::class);
        $this->call(DutyScheduleSeeder::class);
        $this->call(WeekendSetupSeeder::class);
        $this->call(LeaveSeeder::class);
        $this->call(AppScreenSeeder::class);
        // $this->call(FrontSeeder::class);
        $this->call(LocationLogsTableSeeder::class);

        // demo data for        if (config('app.style') === 'demo') {
        if (!session()->has('input') && config('app.style') === 'demo') {
            $this->call(HolidaySeeder::class);
            $this->call(ExpenseSeeder::class);

            $this->call(PaymentSeeder::class);
            $this->call(AllContentSeeder::class);
            $this->call(FeatureSeeder::class);
            $this->call(TestimonialSeeder::class);
            $this->call(PayrollSeeder::class);
            $this->call(TeamSeeder::class);
            $this->call(NotificationTypeSeeder::class);

            // Demo Data Start
            $this->call(VisitSeeder::class);
            $this->call(NoteSeeder::class);
            $this->call(ScheduleSeeder::class);
            $this->call(NoticeSeeder::class);
            $this->call(EmployeeTasksSeeder::class);
            $this->call(AppointmentSeeder::class);
            $this->call(MeetingSeeder::class);
            $this->call(NotificationSeeder::class);
            $this->call(SubscriptionSeeder::class);
            $this->call(AttendanceSeeder::class);
            $this->call(ExpenseSeeder::class);
            $this->call(LocationLogsTableSeeder::class);

            $this->call(GoalSeeder::class);
            $this->call(IndicatorSeeder::class);
            $this->call(ClientSeeder::class);
            $this->call(ProjectSeeder::class);
            $this->call(TaskSeeder::class);
            $this->call(AwardSeeder::class);
            $this->call(TravelSeeder::class);

            $this->call(UserDocumentRequestSeed::class);

        }
        $this->call(ModuleSeeder::class);
    }
}
