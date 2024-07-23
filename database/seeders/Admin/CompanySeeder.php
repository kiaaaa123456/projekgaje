<?php

namespace Database\Seeders\Admin;

use App\Models\Company\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class CompanySeeder extends Seeder
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
        $branch_id = $input['branch_id'] ?? 1;
        // Check if session input data is available
        if ($input) {
            try {
                // Create a company using session input data
                $company =  Company::create([
                    'country_id' => $input['country_id'] ?? 1,
                    'name' => $input['name'] ?? 'Company1',
                    'company_name' => $input['company_name'] ?? 'Company1',
                    'email' => $input['email'] ?? 'test@demo.com',
                    'phone' => $input['phone'] ?? '+8801910077628',
                    'total_employee' => $input['total_employee'] ?? 10,
                    'trade_licence_number' => $input['trade_licence_number'] ?? '1234567890',
                    'business_type' => $input['business_type'] ?? '',
                    'subdomain' => $input['subdomain'] ?? '',
                    'is_main_company' => 'no',
                ]);
                $input['company_id'] = $company->id;
                session()->put('input', $input);
                Log::alert(session()->get('input'));
            } catch (\Throwable $th) {
                Log::error('Company Seeder Failed');
            }
        } else {
            Company::create([
                'country_id' => 223, // United States
                'name' => 'Admin',
                'company_name' => 'Company 1',
                'email' => 'admin@onesttech.com',
                'phone' => '+8801959335555',
                'total_employee' => 400,
                'business_type' => 'Service',
                'is_main_company' => 'yes',
            ]);
        }
    }
}
