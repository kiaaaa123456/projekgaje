<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DesignationSeeder extends Seeder
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

        // Arrays for designations and departments
        $designations = ['Admin', 'HR', 'Staff'];
        $departments = ['Management', 'IT', 'Sales'];

        // Arrays to store data for bulk insert
        $designationData = [];
        $departmentData = [];

        foreach ($designations as $key=>$designation) {
            // Prepare data for designations
            $designationData[] = [
                'title' => $designation,
                'company_id' => $company_id,
                'branch_id' => $branch_id,
                'status_id' => 1,
            ];

            // Prepare data for departments
            $departmentData[] = [
                'title' =>$departments[$key], // Get the next department title
                'company_id' => $company_id,
                'branch_id' => $branch_id,
                'status_id' => 1,
            ];
        }
        // Bulk insert data into 'designations' and 'departments' tables
        DB::table('designations')->insert($designationData);
        DB::table('departments')->insert($departmentData);

        if ($input) {

            // Update input with the last inserted IDs for designations
            $lastDesignationId = DB::table('designations')->pluck('id')->last();
            $lastDepartmentId = DB::table('departments')->pluck('id')->last();

            $input['designation_id'] = $lastDesignationId;
            $input['department_id'] = $lastDepartmentId;

            session()->put('input', $input);
        }
    }

}
