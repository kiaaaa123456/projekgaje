<?php

namespace App\Http\Resources\Hrm;

use App\Models\Visit\Visit;
use Illuminate\Http\Resources\Json\ResourceCollection;

class VisitListCollection extends ResourceCollection
{

    public function toArray($request)
    {

        return [
            'my_visits' => $this->collection->map(function ($visit) {
                return [
                    'id' => $visit->id,
                    'title' => $visit->title,
                    'file'=> $visit->file,
                    'file_ttdbasah'=> $visit->file_ttdbasah,
                    'year' => $visit->year,
                    'month' => $visit->month,
                    'date' => date('jS M, Y', strtotime($visit->date)),
                    'status' => ucfirst($visit->status),
                    'status_color' => visitStatusColor($visit->status),
                ];
            })->toArray(),
            
        ];
    }
    public function with($request)
    {
        return [
            'result' => true,
            'message' => "Vist List Loaded",
            'status' => 200
        ];
    }
}
