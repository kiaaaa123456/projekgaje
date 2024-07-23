<?php

namespace Database\Seeders\Hrm\AppSetting;

use App\Models\Hrm\AppSetting\AppScreen;
use Illuminate\Database\Seeder;

class AppScreenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
            'support', 'attendance', 'task' , 'notice', 'expense', 'leave', 'approval', 'phonebook', 'visit', 'appointments', 'break','report','payroll' 
        ];
        foreach ($menus as $key => $menu) {
            $iconName = $menu . '.png';
            AppScreen::create([
                'name' => plain_text($menu),
                'slug' => $menu,
                'position' => $key + 1,
                'icon' => "assets/appScreenIcons/{$iconName}",
                'status_id' => 1
            ]);
        }
    }
}
