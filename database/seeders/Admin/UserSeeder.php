<?php

namespace Database\Seeders\Admin;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Helpers\CoreApp\Traits\PermissionTrait;

use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{

    use PermissionTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if ($input = session()->get('input') == '') {
            $AdminUser = [
                'name' => "Admin",
                'email' => 'admin@onesttech.com',
                'is_admin' => 1,
                'is_hr' => 0,
                'role_id' => 2,
                'company_id' => 1,
                'country_id' => 223,
                'shift_id' => 1,
                'department_id' => 1,
                'designation_id' => 1,
                'phone' => 'null',
                'permissions' => json_encode($this->adminPermissions()),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'is_email_verified' => 'verified',
                'email_verify_token' => Str::random(10),
                'password' => Hash::make('12345678')
            ];
            DB::table('users')->insert($AdminUser);
        } else {
            $input = session()->get('input');
            $company_id = $input['company_id'] ?? 1;
            $branch_id = $input['branch_id'] ?? 1;
            $name = $input['name'] ?? 'Admin';
            $company_name = $input['company_name'] ?? 'Company 2';
            $email = $input['email'] ?? 'company' . time() . '@onesttech.com';
            $phone = $input['phone'] ?? time();

            $AdminUser = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'is_admin' => 1,
                'is_hr' => 0,
                'role_id' => 2,
                'company_id' => 1,
                'country_id' => 229,
                'shift_id' => 1,
                'department_id' => 1,
                'designation_id' => 1,
                'permissions' => json_encode($this->adminPermissions()),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'is_email_verified' => 'verified',
                'email_verify_token' => Str::random(10),
                'password' => Hash::make('12345678')
            ];
            $newUser = DB::table('users')->insert($AdminUser);

            if ($input) {
                $input['user_id'] =1;
                session()->put('input', $input);
            }
        }
    }
}
