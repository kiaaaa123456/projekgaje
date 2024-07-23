<?php

namespace App\Http\Resources\Hrm;

use Carbon\Carbon;
use App\Models\Visit\Visit;
use App\Helpers\CoreApp\Traits\DateHandler;
use App\Helpers\CoreApp\Traits\TimeDurationTrait;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AppoinmentCollection extends ResourceCollection
{
    use DateHandler,TimeDurationTrait;


    public function toArray($request)
    {
        setlocale(LC_ALL, 'IND');


        return [
            'items' => $this->collection->map(function ($appoinment) {
                return [
                    'id' => $appoinment->id,
                    'title' => $appoinment->title,
                    'description' => $appoinment->description,
                    'date' => Carbon::parse($appoinment->date)->format('F j'),
                    'day' => Carbon::parse($appoinment->date)->format('l'),
                    'time' => $this->dateTimeInAmPm($appoinment->appoinment_start_at),
                    'start_at' => $this->timeFormatInPlainText($appoinment->appoinment_start_at),
                    'end_at' => $this->timeFormatInPlainText($appoinment->appoinment_end_at),
                    'location' => $appoinment->location,
                    'appoinmentWith' => @$appoinment->appoinmentWith->name,
                    'participants' => [],
                    'other_participant' => ''
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'env' => env('FILESYSTEM_DRIVER'),
            'result' => true,
            'message' => "Appointment List",
            'status' => 200
        ];
    }
}
