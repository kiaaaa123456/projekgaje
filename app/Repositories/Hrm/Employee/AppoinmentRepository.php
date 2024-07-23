<?php

namespace App\Repositories\Hrm\Employee;

use Validator;
use Carbon\Carbon;
use App\Models\Visit\VisitImage;
use Illuminate\Support\Facades\Log;
use App\Models\Hrm\Appoinment\Appoinment;
use App\Helpers\CoreApp\Traits\DateHandler;
use App\Helpers\CoreApp\Traits\FileHandler;
use App\Http\Resources\Hrm\AppoinmentCollection;
use App\Helpers\CoreApp\Traits\TimeDurationTrait;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Helpers\CoreApp\Traits\FirebaseNotification;
use App\Models\Hrm\Appoinment\AppoinmentParticipant;
use App\Models\coreApp\Relationship\RelationshipTrait;
use App\Http\Resources\Hrm\AppoinmentDetailsCollection;
use App\Helpers\CoreApp\Traits\GeoLocationTrait;


class AppoinmentRepository
{

    use RelationshipTrait, FileHandler, ApiReturnFormatTrait, DateHandler, TimeDurationTrait, FirebaseNotification;

    protected $appoinment;
    protected $appoinment_participant;

    public function __construct(Appoinment $appoinment, AppoinmentParticipant $appoinment_participant)
    {
        $this->appoinment = $appoinment;
        $this->appoinment_participant = $appoinment_participant;
    }

    public function getAllAppoinment()
    {
        $appoinments = $this->appoinment->query();
        $appoinments = $appoinments
            ->where(function ($query) {
                $query->where('created_by', auth()->user()->id)
                    ->orWhere('appoinment_with', auth()->user()->id);
            })
            ->when(request()->has('month'), function ($query) {
                $query->where('date', 'LIKE', '%' . request('month') . '%');
            })
            ->when(!request()->has('month'), function ($query) {
                $query->limit(5);
            })

            ->orderBy('id', 'desc')->get();
        return new AppoinmentCollection($appoinments);
    }
    
    public function getDetails()
    {
        $appoinment = $this->appoinment->query();
        $appoinment = $appoinment
        // ->with('participants')
        //     ->where(function ($query) {
        //         $query->where('created_by', auth()->user()->id)
        //             ->orWhere('appoinment_with', auth()->user()->id);
        //     })
            ->where('id', request('id'))

            ->orderBy('id', 'desc')->first();
        if ($appoinment) {
            Carbon::setLocale('id');

            $appointmentDetails = [
                'id' => $appoinment->id,
                'title' => $appoinment->title,
                'description' => $appoinment->description,
                'date' => Carbon::parse($appoinment->date)->format('d-m-Y'),
                'day' => Carbon::parse($appoinment->date)->format('l'),
                'time' => $this->dateTimeInAmPm($appoinment->appoinment_start_at),
                'start_at' => $appoinment->appoinment_start_at,
                'end_at' => $appoinment->appoinment_end_at,
                'location' => $appoinment->location,
                'appoinmentWith' => @$appoinment->appoinmentWith->name,
                'file' => $appoinment->file,
                'other_participant' => [],
            ];
            return $this->responseWithSuccess(__('Appointment Details'), $appointmentDetails, 200);
        } else {
            return $this->responseWithSuccess('Appointment Not Found', [], 200);
        }
    }

    public function store($request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'date' => 'required',
                'title' => 'required'
                // 'appoinment_start_at' => 'required',
                // 'appoinment_end_at' => 'required',
            ]
        );

      

        //Checking creator schedule time
        // $appoinment_creator_schedules = Appoinment::where('date', $request->date)
        //     ->where('appoinment_start_at', '<=', $request->appoinment_start_at)
        //     ->where('appoinment_end_at', '>=', $request->appoinment_start_at)
        //     ->whereHas('participants', function ($query) {
        //         return $query->where([
        //             ['participant_id', auth()->user()->id],
        //             ['appoinment_ended_at', null],
        //             ['is_agree', 1],
        //         ]);
        //     })
        //     ->where(function ($query) use ($request) {
        //         $query->where('created_by', auth()->user()->id)
        //             ->orWhere('appoinment_with', auth()->user()->id);
        //     })
        //     ->with('participants')
        //     ->first();

        //Checking Participant schedule time
        // $appoinment_participant_schedules = Appoinment::where('date', $request->date)
        //     ->where('appoinment_start_at', '<=', $request->appoinment_start_at)
        //     ->where('appoinment_end_at', '>=', $request->appoinment_start_at)
        //     ->whereHas('participants', function ($query) use ($request) {
        //         return $query->where([
        //             ['participant_id', $request->appoinment_with],
        //             ['appoinment_ended_at', null],
        //             ['is_agree', 1],
        //         ]);
        //     })
        //     ->where(function ($query) use ($request) {
        //         $query->where('created_by', $request->appoinment_with)
        //             ->orWhere('appoinment_with', $request->appoinment_with);
        //     })
        //     ->with('participants')
        //     ->first();

        // if ($appoinment_creator_schedules) {
        //     return $this->responseWithError(__('Anda sudah membuat laporan harian. Silakan coba lagi setelah ' . $this->dateFormatInPlainText($request->date . ' ' . $appoinment_creator_schedules->appoinment_end_at)), [], 200);
        // }
        // if ($appoinment_participant_schedules) {
        //     return $this->responseWithError(__('Participant already scheduled, Please try after ' . $this->dateFormatInPlainText($request->date . ' ' . $appoinment_participant_schedules->appoinment_end_at)), [], 200);
        // }

        $check = Appoinment::where('created_by', auth()->user()->id)->where('company_id',auth()->user()->company_id)
        // ->where('date',$request->date)
        ->where('id',$request->id)
        ->count();
        Log::info('This is an informational message.'.$request->id);
        $checkDate = Appoinment::where('created_by', auth()->user()->id)->where('company_id',auth()->user()->company_id)
        ->where('date',$request->date)
        ->where('title',$request->title)
        ->where('description',$request->description)
        ->count();
        if($check == 0 && $checkDate == 0){
            $appoinment = new Appoinment;
            $appoinment->created_by = auth()->user()->id;
            $appoinment->company_id = auth()->user()->company_id;
            $appoinment->date = $request->date;
            $appoinment->appoinment_with = $request->appoinment_with;
            $appoinment->title = $request->title;
            $appoinment->location = getGeocodeData($request->latitude, $request->longitude);
            $appoinment->latitude = $request->latitude;
            $appoinment->longitude = $request->longitude;
            $appoinment->description = $request->description;
            $appoinment->appoinment_start_at = $request->appoinment_start_at ?? null;
            $appoinment->appoinment_end_at = $request->appoinment_end_at ?? null;

            $fileupload = $request->file('file');
            $fileuploadName = time() . "-aktivitasharian." . 
            $fileupload->getClientOriginalExtension();
            $upload_path = 'aktivitasharian/';
            $appoinment->file = $upload_path . $fileuploadName;
            $success = $fileupload->move($upload_path, $fileuploadName);
            
            $appoinment->save();

            $reCheck = Appoinment::where('created_by', auth()->user()->id)->where('company_id',auth()->user()->company_id)->where('date',$request->date)
            ->where('title', $request->title)->where('description',$request->description)->count();
            $reCheckId = Appoinment::where('created_by', auth()->user()->id)->where('company_id',auth()->user()->company_id)->where('date',$request->date)
            ->where('title', $request->title)->where('description',$request->description)->first();
            if($reCheck > 1){
                $appoinmentDelete = Appoinment::find($reCheckId->id);
                    $appoinment->delete();
            }

            // //Creator Participant
            // $appoinment_participant = new AppoinmentParticipant;
            // $appoinment_participant->participant_id = $appoinment->created_by;
            // $appoinment_participant->appoinment_id = $appoinment->id;
            // $appoinment_participant->is_agree = 1;
            // $appoinment_participant->save();

            // //Another Participant
            // $appoinment_participant = new AppoinmentParticipant;
            // $appoinment_participant->participant_id = $appoinment->appoinment_with;
            // $appoinment_participant->appoinment_id = $appoinment->id;
            // $appoinment_participant->is_agree = 1;
            // $appoinment_participant->save();

            if (isset($request->attachment_file)) {
                $visit_image = new VisitImage;
                $visit_image->imageable_id = $appoinment->id;
                $visit_image->imageable_type = 'App\Models\Hrm\Appoinment';
                $visit_image->file_id = $this->uploadImage($request->attachment_file, 'uploads/employeeDocuments')->id;
                $visit_image->save();
            }
            //Appointment Notification message
            $notify_body = 'You have scheduled an appointment with ' . auth()->user()->name . ' on ' . $this->dateFormatInPlainText($appoinment->date . ' ' . $appoinment->appoinment_start_at);

            $details = [
                'title' => 'New Appointment Scheduled',
                'body' => $notify_body,
                'actionText' => 'View',
                'actionURL' => [
                    'app' => 'appointment_request',
                    'web' => url('dashboard/user/appointment'),
                    'target' => '_blank',
                ],
                'sender_id' => auth()->user()->id
            ];

            //send notification to manager
            // if ($appoinment->appoinment_with != null) {
            //     // $this->sendFirebaseNotification($leaveRequest->user->manager_id, 'leave_approved', $leaveRequest->id, route('leaveRequest.index'));
            //     // $this->sendFirebaseNotification($appoinment->appoinment_with, 'appointment_request', $appoinment->id, null);
            //     $this->sendChannelFirebaseNotification('user'.$appoinment->appoinment_with, 'appointment_request', null, route('leaveRequest.index'),$details['title'],$details['body'],null);

            //     sendDatabaseNotification($appoinment->appoinmentWith, $details);
            // }
        }else{
            if (isset($request->id)) {
                $check = Appoinment::where('created_by', auth()->user()->id)->where('company_id',auth()->user()->company_id)->where('id',$request->id)->first();
                $appoinment = Appoinment::find($check->id);
                $appoinment->created_by = auth()->user()->id;
                $appoinment->company_id = auth()->user()->company_id;
                $appoinment->title = $request->title;
                $appoinment->location = getGeocodeData($request->latitude, $request->longitude);
                $appoinment->latitude = $request->latitude;
                $appoinment->longitude = $request->longitude;
                $appoinment->description = $request->description;
                $appoinment->appoinment_start_at = $request->appoinment_start_at ?? null;
                $appoinment->appoinment_end_at = $request->appoinment_end_at ?? null;

                if (isset($request->file)) {
                    $fileupload = $request->file('file');
                    $fileuploadName = time() . "-aktivitasharian." . 
                    $fileupload->getClientOriginalExtension();
                    $upload_path = 'aktivitasharian/';
                    $appoinment->file = $upload_path . $fileuploadName;
                    $success = $fileupload->move($upload_path, $fileuploadName);
                }
                $appoinment->update(); 
            }

        }

        return $this->responseWithSuccess('Appoinment Created Successfully', [], 200);
    }
    public function update($request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required',
                'date' => 'required',
                'title' => 'required',
                'appoinment_start_at' => 'required',
                'appoinment_end_at' => 'required',
            ]
        );

        if ($validator->fails()) {
            return $this->responseWithError(__('Validation field required'), $validator->errors(), 422);
        }

        $appoinment = Appoinment::find($request->id);
        $appoinment->date = $request->date;
        $appoinment->appoinment_with = $request->appoinment_with;
        $appoinment->title = $request->title;
        $appoinment->location = $request->location;
        $appoinment->latitude = $request->latitude;
        $appoinment->longitude = $request->longitude;
        $appoinment->description = $request->description;
        $appoinment->appoinment_start_at = $request->appoinment_start_at;
        $appoinment->appoinment_end_at = $request->appoinment_end_at;
        if (isset($request->file)) {
            $fileupload = $request->file('file');
            $fileuploadName = time() . "-aktivitasharian." . 
            $fileupload->getClientOriginalExtension();
            $upload_path = 'aktivitasharian/';
            $appoinment->file = $upload_path . $fileuploadName;
            $success = $fileupload->move($upload_path, $fileuploadName);
        }
        $appoinment->update();

        //check appoinment participant exist or not
        // $appoinment_participant = AppoinmentParticipant::where('appoinment_id', $appoinment->id)->where('participant_id', $appoinment->appoinment_with)->first();
        // if (!$appoinment_participant) {
        //     $appoinment_participant = new AppoinmentParticipant;
        //     $appoinment_participant->participant_id = $appoinment->appoinment_with;
        //     $appoinment_participant->appoinment_id = $appoinment->id;
        //     $appoinment_participant->save();
        // }
        // $old_participant = AppoinmentParticipant::where('appoinment_id', $appoinment->id)
        //     ->whereNotIn('participant_id', [$appoinment->appoinment_with, $appoinment->created_by])->delete();

        // if (isset($request->attachment_file)) {
        //     $visit_image = new VisitImage;
        //     $visit_image->imageable_id = $appoinment->id;
        //     $visit_image->imageable_type = 'App\Models\Visit\Visit';
        //     $visit_image->file_id = $this->uploadImage($request->attachment_file, 'uploads/employeeDocuments')->id;
        //     $visit_image->save();
        // }

        return $this->responseWithSuccess('Appoinment Updated Successfully', [], 200);
    }

    public function appoinmentChangeStatus($request)
    {
        // $validator = Validator::make(
        //     $request->all(),
        //     [
        //         'appoinment_id' => 'required',
        //         'status' => 'required|in:start,end,agree,disagree,present,absent',
        //     ]
        // );

        // if ($validator->fails()) {
        //     return $this->responseWithError(__('Validation field required'), $validator->errors(), 422);
        // }
        // $participant = AppoinmentParticipant::where('appoinment_id', $request->appoinment_id)->where('participant_id', auth()->user()->id)->first();
        // if (!$participant) {
        //     return $this->responseWithError(__('You are not participant of this appoinment'), [], 422);
        // }
        // switch ($request->status) {
        //     case 'start':
        //         $participant->is_agree = 1;
        //         $participant->is_present = 1;
        //         $participant->present_at = date('Y-m-d H:i:s');
        //         $participant->appoinment_started_at = date('Y-m-d H:i:s');
        //         break;
        //     case 'end':
        //         if ($participant->appoinment_started_at != null) {
        //             $participant->appoinment_ended_at = date('Y-m-d H:i:s');
        //             $participant->appoinment_duration = $this->timeDifference($participant->appoinment_started_at, $participant->appoinment_ended_at);
        //         } else {
        //             return $this->responseWithError(__('Appoinment not started yet'), [], 422);
        //         }
        //         break;
        //     case 'agree':
        //         $participant->is_agree = 1;
        //         break;
        //     case 'disagree':
        //         $participant->is_agree = 0;
        //         break;
        //     case 'present':
        //         $participant->is_present = 1;
        //         break;
        //     case 'absent':
        //         $participant->is_present = 0;
        //         break;
        //     default:
        //         return $participant;
        //         break;
        // }
        // $participant->save();

        return $this->responseWithSuccess('Appoinment Status Changed Successfully', [], 200);
    }
    public function deleteAppoinment($request)
    {
        $appoinment = Appoinment::find(request()->id);
        if ($appoinment->created_by != auth()->user()->id) {
            return $this->responseWithError(__('You are not creator of this appoinment'), [], 422);
        }
        $appoinment->delete();

        return $this->responseWithSuccess('Appoinment Deleted Successfully', [], 200);
    }

    public function staffProfileDatatable($request)
    {
        $appoinment = $this->appoinment
            ->where(function ($query) use ($request) {
                $query->where('created_by', auth()->user()->id)
                    ->orWhere('appoinment_with', auth()->user()->id);
            });
        if (@$request->daterange) {
            $dateRange = explode(' - ', $request->daterange);
            $from = date('Y-m-d', strtotime($dateRange[0]));
            $to = date('Y-m-d', strtotime($dateRange[1]));
            $appoinment = $appoinment->whereBetween('date', start_end_datetime($from, $to));
        }
        if (@$id) {
            $appoinment = $appoinment->where('id', $id);
        }

        return $this->appointmentDatatable($appoinment);
    }


    public function profileDataTable($request, $id = null)
    {
        $appoinment = $this->appoinment
            ->where(function ($query) use ($request) {
                $query->where('created_by', $request->user_id)
                    ->orWhere('appoinment_with', $request->user_id);
            });
        if (@$request->daterange) {
            $dateRange = explode(' - ', $request->daterange);
            $from = date('Y-m-d', strtotime($dateRange[0]));
            $to = date('Y-m-d', strtotime($dateRange[1]));
            $appoinment = $appoinment->whereBetween('date', start_end_datetime($from, $to));
        }
        if (@$id) {
            $appoinment = $appoinment->where('id', $id);
        }

        return $this->appointmentDatatable($appoinment);
    }

    public function appointmentDatatable($appoinment)
    {
        return datatables()->of($appoinment->latest()->get())
            ->addColumn('title', function ($data) {
                return $data->title;
            })
            ->addColumn('description', function ($data) {
                return $data->description;
            })
            ->addColumn('appoinment_with', function ($data) {
                return $data->appoinmentWith->name;
            })
            ->addColumn('date', function ($data) {
                return $data->date;
            })
            ->addColumn('start_at', function ($data) {
                return $data->appoinment_start_at;
            })
            ->addColumn('end_at', function ($data) {
                return $data->appoinment_end_at;
            })
            ->addColumn('location', function ($data) {
                return $data->location;
            })

            ->addColumn('file', function ($data) {
                $files_array = '';
                foreach ($data->visitImages as $key => $image) {
                    $files_array .= '<a href="' . uploaded_asset($image->file_id) . '" target="_blank"> <img height="40px" width="40px" src="' . uploaded_asset($image->file_id) . '"/> </a>';
                }
                return $files_array;
            })

            ->addColumn('status', function ($data) {
                return '<span class="badge badge-' . @$data->status->class . '">' . @$data->status->name . '</span>';
            })
            ->rawColumns(array('date', 'appoinment_with', 'title', 'start_at', 'end_at', 'location', 'file', 'status'))
            ->make(true);
    }

    public function dataTable($request)
    {
        $leaveRequest = $this->leaveRequest->query();
        if (auth()->user()->role->slug == 'staff') {
            $leaveRequest = $leaveRequest->where('user_id', auth()->id());
        } else {
            $leaveRequest->when(\request()->get('user_id'), function (Builder $builder) {
                return $builder->where('user_id', \request()->get('user_id'));
            });
        }
        $leaveRequest->when(\request()->get('daterange'), function (Builder $builder) {
            $date = explode(' - ', \request()->get('daterange'));
            return $builder->whereBetween('apply_date', [$this->databaseFormat($date[0]), $this->databaseFormat($date[1])]);
        });
        $leaveRequest->when(\request()->get('short_by'), function (Builder $builder) {
            return $builder->where('status_id', \request()->get('short_by'));
        });
        $leaveRequest->when(\request()->get('department_id'), function (Builder $builder) {
            return $builder->whereHas('assignLeave', function (Builder $builder) {
                return $builder->where('department_id', \request()->get('department_id'));
            });
        });
        return $this->leaveDataTable($leaveRequest);
    }


    // new functions
    function fields()
    {
        return [
            _trans("common.No"),
            _trans('common.Tanggal / Waktu'),
            _trans("common.Rencana"),
            _trans("common.Realisasi"),
            _trans('common.Fasilitator'),            
            _trans('common.Lokasi'),
            _trans('common.File'),
            _trans('common.Status'),
        ];
    }

    public function table($request)
    {
        // Log::info($request->all());
        $appoinment = $this->appoinment;

        // if (!is_Admin()) {
        //     $user_id = auth()->user()->id;
        // } else {
        //     $user_id = @$request->user_id;
        // }
        // if (@$user_id) {
        //     $appoinment = $appoinment->orWhere('created_by', $user_id)->orWhere('appoinment_with', $user_id);
        // }
        // if ($request->search) {
        //     $appoinment = $appoinment->where('title', 'like', '%' . $request->search . '%')->orWhere('location', 'like', '%' . $request->search . '%');
        // }
        $files = $appoinment->orderBy('id', 'desc')->paginate($request->limit ?? 10);
        return [
            'data' => $files->map(function ($data) {
                $files_array = '';
                foreach ($data->visitImages as $key => $image) {
                    $files_array .= '<a href="' . uploaded_asset($image->file_id) . '" target="_blank"> <img height="40px" width="40px" src="' . uploaded_asset($image->file_id) . '"/> </a>';
                }
                return [
                    'id' => $data->id,
                    'date' => "".date('d-m-Y', strtotime($data->date))."<br>".$data->appoinment_start_at." - ".$data->appoinment_end_at."",
                    'title' => "<p class='text-wrap'>".$data->title."</p>",
                    'description' => "<p class='text-wrap'>".$data->description."</p>",
                    'fasilitator' => @$data->createdBy->name,                         
                    'location' => "<p class='text-wrap'>".$data->location."</p>",
                    'file' => "<a href='".url(''.$data->file.'')."' target='_blank'><i class='fa fa-file'></i></a>",
                    // 'status' => '<small class="badge badge-' . @$data->status->class . '">' . @$data->status->name . '</small>',
                    'status' => '<small class="badge badge-success">Aktif</small>',
                ];
            }),
            'pagination' => [
                'total' => $files->total(),
                'count' => $files->count(),
                'per_page' => $files->perPage(),
                'current_page' => $files->currentPage(),
                'total_pages' => $files->lastPage(),
                'pagination_html' =>  $files->links('backend.pagination.custom')->toHtml(),
            ],
        ];
    }
}
