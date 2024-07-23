<?php

namespace App\Http\Resources\Hrm;

use App\Helpers\CoreApp\Traits\DateHandler;
use Illuminate\Http\Resources\Json\ResourceCollection;

class LeaveRequestCollection extends ResourceCollection
{
    use DateHandler;

    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'leaveRequests' => $this->collection->map(function ($data) {
                $variable = @$data->status->name;

                $result = match ($variable) {
                    'Cancel' => 'Dibatalkan',
                    'Active' => 'Disetujui',
                    'Pending' => 'Pengajuan',
                    'Reject' => 'Ditolak',
                    default => $variable,
                };

                return [
                    'id' => $data->id,
                    'type' => $data->assignLeave->type->name,
                    'requested_on' => $data->apply_date,
                    'period' => $data->leave_from,
                    'days' => $data->days,
                    'note' => $data->reason,
                    'apply_date' => $this->getMonthDate($data->apply_date),
                    'status' => $result,
                    'color_code' => appColorCodePrefix() . @$data->status->color_code
                ];
            })
        ];
    }
}
