<?php

namespace Database\Seeders\Hrm;

use App\Models\Company\Company;
use Illuminate\Database\Seeder;
use App\Models\Hrm\Attendance\Holiday;
use Faker\Factory as Faker;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
       
        
        $holidays = [
            '2023-01-01'=>[
                'New Year',  
                'Federal Holiday',
                ''
            ],
            '2023-01-17'=>[
                'Martin Luther King Jr Day',  
                'Federal Holiday',
                '3rd Monday in January'
            ],
            '2023-02-21'=>[
                'Washington\'s Birthday',  
                'Federal Holiday',
                '3rd Monday in February'
            ],
            '2023-05-26'=>[
                'Memorial Day',  
                'Federal Holiday',
                'Last Monday in May'
            ],
            '2023-07-04'=>[
                'Independence Day',  
                'Federal Holiday',
                ''
            ],
            '2023-09-01'=>[
                'Labor Day',  
                'Federal Holiday',
                '1st Monday in September'
            ],
            '2023-10-13'=>[
                'Columbus Day',  
                'Federal Holiday',
                '2nd Monday in October'
            ],
            '2023-11-11'=>[
                'Veterans Day',  
                'Federal Holiday',
                '11th November'
            ],
            '2023-11-24'=>[
                'Thanksgiving Day',  
                'Federal Holiday',
                '4th Thursday in November'
            ],
            '2023-12-25'=>[
                'Christmas Day',  
                'Federal Holiday',
                ''
            ]
        ];

        if ($input = session()->get('input')) {
            $company_id = $input['company_id'] ?? 1;
            $branch_id = $input['branch_id'] ?? 1;

            session()->put('input', $input);
        } else {
            $company_id = 1;
            $branch_id = 1;
        }
            foreach( $holidays as $date=>$x){
                $holiday= new Holiday();
                $holiday->company_id = $company_id;
                $holiday->branch_id = $branch_id;
                $holiday->title = $x[0];
                $holiday->type = $x[1];
                $holiday->description = $x[2]; 
                $holiday->start_date = $date;
                $holiday->end_date = $date;
                $holiday->status_id = 1;
                $holiday->save();
            }
        }


    
}
