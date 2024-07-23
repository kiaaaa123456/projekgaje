<?php

namespace App\Http\Resources\Hrm;

use App\Helpers\CoreApp\Traits\DateHandler;
use Illuminate\Http\Resources\Json\ResourceCollection;
use DB;
class EvkinCollection extends ResourceCollection
{

    use DateHandler;

    public function convertBulan($bulan)
{
    switch ($bulan) {
        case '01':
            return 'Januari';
        case '02':
            return 'Februari';
        case '03':
            return 'Maret';
        case '04':
            return 'April';
        case '05':
            return 'Mei';
        case '06':
            return 'Juni';
        case '07':
            return 'Juli';
        case '08':
            return 'Agustus';
        case '09':
            return 'September';
        case '10':
            return 'Oktober';
        case '11':
            return 'November';
        case '12':
            return 'Desember';
        default:
            return 'Bulan tidak valid';
    }
}

    public function toArray($request)
    {

      

        return [
            'my_evkin' => $this->collection->map(function ($visit) {
                return [
                    'id' => $visit->id,
                    'nilai' => $visit->nilai,
                    'bulan'=>$this->convertBulan($visit->bulan),
                    'tahun' => $visit->tahun,
                ];
            })->toArray(),
            
        ];
    }

    public function with($request)
    {
        return [
            'env' => env('FILESYSTEM_DRIVER'),
            'result' => true,
            'message' => "Vist Details",
            'status' => 200
        ];
    }
}
