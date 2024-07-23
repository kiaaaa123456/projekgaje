<?php

namespace App\Repositories\Hrm\Visit;

use Validator;
use App\Models\Visit\Visit;
use Illuminate\Support\Str;
use App\Models\Visit\VisitNote;
use App\Models\Visit\VisitImage;
use Illuminate\Support\Facades\DB;
use App\Models\Visit\VisitSchedule;
use Illuminate\Database\Schema\Builder;
use App\Helpers\CoreApp\Traits\DateHandler;
use App\Helpers\CoreApp\Traits\FileHandler;
use App\Http\Resources\Hrm\VisitCollection;
use App\Http\Resources\Hrm\VisitListCollection;
use App\Http\Resources\Hrm\EvkinCollection;
use App\Http\Resources\Hrm\VisitHistoryCollection;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use App\Models\coreApp\Relationship\RelationshipTrait;
use App\Repositories\Hrm\Visit\VisitScheduleRepository;
use Auth;

class VisitRepository
{

    use RelationshipTrait, FileHandler, ApiReturnFormatTrait, DateHandler;

    protected $visit;

    public function __construct(Visit $visit)
    {
        $this->visit = $visit;
    }


    public function getAll()
    {
        return $this->visit->with('user')->get();
    }

    public function getList()
    {
        $visits = $this->visit->orderBy('id', 'desc')
        ->where('user_id', auth()->user()->id)
        ->get();
        return new VisitListCollection($visits);
    }

    public function getListEvkin()
    {
        $visits = DB::table('evkin')
        ->select('evkin.id','evkin.nilai','periode_evkin.bulan','periode_evkin.tahun')
        ->join('periode_evkin','evkin.periode_id','periode_evkin.id')
        ->orderBy('evkin.id', 'desc')
        ->where('evkin.user_id', auth()->user()->id)
        ->get();
        return new EvkinCollection($visits);
    }

    public function getListForWeb($request, $id)
    {
        $visits = $this->visit->query()
        ->where('user_id', $id);
        $visits->latest()->get();
        return $this->dataTable($visits);
    }
    public function getUserVisitListForWeb($request)
    {
        $visits = $this->visit->query()->where('user_id', auth()->user()->id);
        $visits->latest()->get();
        return $this->dataTable($visits);
    }

    public function store($request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'year' => 'required|max:50',
            'month' => 'required',
            'file' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->responseWithError(__('Required fields are missing'), $validator->errors(), 422);
        }
        $visit = new $this->visit();
        $visit->user_id = auth()->id();
        $visit->company_id = 1;
        $visit->date = date('Y-m-d');
        $visit->year = $request->year;
        $visit->month = $request->month;

        $fileupload = $request->file('file');
        $fileuploadName = time() . "-aktivitasbulanan." . 
        $fileupload->getClientOriginalExtension();
        $upload_path = 'aktivitasbulanan/';
        $visit->file = $upload_path . $fileuploadName;
        $success = $fileupload->move($upload_path, $fileuploadName);
        

        $visit->save();
        if ($visit) {
            return $this->responseWithSuccess('Laporan bulanan berhasil dibuat', [], 200);
        } else {
            return $this->responseWithError('Laporan bulanan gagal dibuat, silakan coba lagi', [], 400);
        }
    }


    public function visitHistoryDatatable($request)
    {
        $visits = $this->visit->query();
        $visits->when($request->daterange, function ($query) {
            $date = explode(' - ', \request()->get('daterange'));
            return $query->whereBetween('date', [$this->databaseFormat($date[0]), $this->databaseFormat($date[1])]);
        });
        $visits->when(\request()->get('user_id'), function ($query) {
            return $query->where('user_id', \request()->get('user_id'));
        });
        $visits->when(\request()->get('status'), function ($query) {
            return $query->where('status', \request()->get('status'));
        });


        return $this->dataTable($visits->latest()->get());
    }

    public function dataTable($visits)
    {
        return datatables()->of($visits)
            ->addColumn('action', function ($data) {
                $action_button = '';
                $view = _trans('common.View');
                if (hasPermission('visit_read')) {
                    $action_button .= '<a href="' . route('visit.details', $data->id) . '" class="dropdown-item"> ' . $view . '</a>';
                }
                $button = '<div class="flex-nowrap">
                    <div class="dropdown">
                        <button class="btn btn-white dropdown-toggle align-text-top action-dot-btn" data-boundary="viewport" data-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">' . $action_button . '</div>
                    </div>
                </div>';
                return $button;
            })
            ->addColumn('employee_name', function ($data) {
                return @$data->user->name;
            })
            ->addColumn('date', function ($data) {
                return $this->dateFormatWithoutTime($data->date);
            })
            ->addColumn('title', function ($data) {
                return @$data->title;
            })
            ->addColumn('file', function ($data) {
                if ($data->visitImages != null) {
                    $image_links = '';
                    foreach ($data->visitImages as $key => $image) {
                        $image_links .= '<a href="' . uploaded_asset($image->file_id) . '" download class="btn btn-white btn-sm"><i class="fas fa-download"></i></a>';
                    }
                    return '<p style"display:flex">' . $image_links . '</p>';
                } else {
                    return _trans('common.No File');
                }
            })
            ->addColumn('description', function ($data) {
                return @$data->description;
            })
            ->addColumn('status', function ($data) {
                return ucfirst($data->status);
            })
            ->addColumn('cancel_note', function ($data) {
                return $data->cancel_note;
            })
            ->rawColumns(array('employee_name', 'year', 'month',  'file', 'status', 'action'))
            ->make(true);
    }

    public function createNewVisit($request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'year' => 'required|max:50',
                'month' => 'required'
            ]
        );

       

        // $visit = new Visit();
        // $visit->date = $request->date;
        // $visit->title = $request->title;
        // $visit->description = $request->description;
        // $visit->user_id = auth()->id();
        // $visit->company_id = auth()->user()->company_id;
        // $visit->save();
        // $result = $visit->makeHidden(['created_at', 'updated_at']);
        $check = $this->visit->query()->where('user_id',auth()->id())->where('year',$request->year)->where('month',$request->month)->first();
        if($check == null){
            $visit = new Visit();
            $visit->user_id = auth()->id();
            $visit->company_id = 1;
            $visit->date = date('Y-m-d');
            $visit->year = $request->year;
            $visit->month = $request->month;
            if (isset($request->file)) {
                $profileImage = $request->file('file');
                $profileImageSaveAsName = time() . "-laporanbulanan." . 
                $profileImage->getClientOriginalExtension();
                $upload_path = 'laporanbulanan/';
                $visit->file = $upload_path . $profileImageSaveAsName;
                $success = $profileImage->move($upload_path, $profileImageSaveAsName);
            }
            if (isset($request->file_ttdbasah)) {
                $profileImageTtd = $request->file('file_ttdbasah');
                $profileImageSaveAsNameTtd = time() . "-laporanbulananaktv." . 
                $profileImageTtd->getClientOriginalExtension();
                $upload_path = 'laporanbulanan/';
                $visit->file_ttdbasah = $upload_path . $profileImageSaveAsNameTtd;
                $success = $profileImageTtd->move($upload_path, $profileImageSaveAsNameTtd);
            }

            $visit->save();
            if ($visit) {
                return $this->responseWithSuccess('Laporan bulanan berhasil dibuat', [], 200);
            } else {
                return $this->responseWithError('Laporan bulanan gagal dibuat, silakan coba lagi', [], 400);
            }
        }else{
            $visit = Visit::find($check->id);
            $visit->user_id = auth()->id();
            $visit->company_id = 1;
            $visit->date = date('Y-m-d');
            $visit->year = $request->year;
            $visit->month = $request->month;

            if (isset($request->file)) {
                $profileImage = $request->file('file');
                $profileImageSaveAsName = time() . "-laporanbulanan." . 
                $profileImage->getClientOriginalExtension();
                $upload_path = 'laporanbulanan/';
                $visit->file = $upload_path . $profileImageSaveAsName;
                $success = $profileImage->move($upload_path, $profileImageSaveAsName);
            }
            if (isset($request->file_ttdbasah)) {
                $profileImageTtd = $request->file('file_ttdbasah');
                $profileImageSaveAsNameTtd = time() . "-laporanbulanan." . 
                $profileImageTtd->getClientOriginalExtension();
                $upload_path = 'laporanbulanan/';
                $visit->file_ttdbasah = $upload_path . $profileImageSaveAsNameTtd;
                $success = $profileImageTtd->move($upload_path, $profileImageSaveAsNameTtd);
            }
            $visit->save();

            return $this->responseWithSuccess('Laporan bulanan yang sebelumnya sudah Anda buat berhasil diperbaharui', [], 200);
        }
    }

    public function getVisitById($id)
    {
        $visit = $this->visit->where('id', $id)->where('user_id', auth()->user()->id)->first();
        return $visit;
    }

    public function getVisitDetails($id)
    {
        $visit = $this->visit->where('id', $id)->with('schedules')->first();
        return $visit;
    }

    public function getVisitHistoryList($request)
    {

        $results = [];
        try {
            if ($request->has('month') && $request->month != '') {
                $requestYearMonth = $request->month;
            } else {
                $requestYearMonth = date('Y-m');
            }

            $visit_data = Visit::where('user_id', auth()->user()->id)
            //->whereIn('status', ['completed', 'cancelled'])
            //->where('date', 'LIKE', '%' . $requestYearMonth . '%')
            ->get();
            if ($visit_data->count() > 0 && $visit_data != null) {
                return new VisitHistoryCollection($visit_data);
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 500);
        }
    }

    public function visitDetails($id)
    {
        $visit = $this->visit->where('id', $id)->where('user_id', auth()->user()->id)->get();
        return $visit;
    }

    public function updateVisit($request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required',
            ]
        );
        if ($validator->fails()) {
            return $this->responseWithError(__('Validation field required'), $validator->errors(), 422);
        }


        $update_visit = Visit::find($request->id);
        $update_visit->title = $request->title;
        $update_visit->description = $request->description;
        $update_visit->save();

        if (request()->has('visit_images')) {
            foreach ($request->visit_images as $key => $image) {
                $visit_image = new \App\Models\Visit\VisitImage;
                $visit_image->imageable_id = $request->id;
                $visit_image->imageable_type = 'App\Models\Visit\Visit';
                $visit_image->file_id = $this->uploadImage($image, 'uploads/employeeDocuments')->id;
                $visit_image->save();
            }
        }
        $result = $update_visit->makeHidden(['created_at', 'updated_at']);
        return $this->responseWithSuccess(__('Visit Updated successfully'), $result, 200);
    }

    public function uploadVisitImage($request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required',
                'visit_image' => 'required',
            ]
        );
        if ($validator->fails()) {
            return $this->responseWithError(__('Validation field required'), $validator->errors(), 422);
        }

        $visit_image = new VisitImage;
        $visit_image->imageable_id = $request->id;
        $visit_image->imageable_type = 'App\Models\Visit\Visit';
        if ($request->has('visit_image')) {
            $visit_image->file_id = $this->uploadImage($request->visit_image, 'uploads/employeeDocuments')->id;
        }else{
            $visit_image->file_id = $request->visit_image;
        }
        $visit_image->save();

        return $visit_image;
    }

    public function getVisitImages($id)
    {

        $visit_images = $this->getVisitById($id)->visitImages;
        return $visit_images;
    }

    public function removeVisitImage($visit_id, $image_id)
    {

        $visit_images = $this->getVisitById($visit_id)->visitImages->where('id', $image_id)->first();
        if ($visit_images) {
            try {
                deleteImage($visit_images->file()->img_path);
            } catch (\Throwable $th) {
            }
            $delete_upload = $visit_images->file()->delete();
            if ($delete_upload) {
                $visit_images->delete();
            }
        }
        return true;
    }

    public function createNote($request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'visit_id' => 'required',
                'note' => 'required',
            ]
        );
        if ($validator->fails()) {
            return $this->responseWithError(__('Validation field required'), $validator->errors(), 422);
        }
        $visit_info = Visit::where('id', $request->visit_id)->where('user_id', auth()->user()->id)->first();

        $visit_note = new VisitNote;
        $visit_note->visit_id = $request->visit_id;
        $visit_note->note = $request->note;
        $visit_note->status = $visit_info->status;
        $visit_note->save();
    }

    public function changeVisitStatus($request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'visit_id' => 'required',
                // 'date' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'status' => 'required|in:completed,cancelled,reached,started',
            ]
        );
        if ($validator->fails()) {
            return $this->responseWithError(__('Validation field required'), $validator->errors(), 422);
        }

        if ($request->status == 'cancelled') {
            $validator = Validator::make(
                $request->all(),
                [
                    'cancel_note' => 'required',
                ]
            );
        }
        if ($validator->fails()) {
            return $this->responseWithError(__('Validation field required'), $validator->errors(), 422);
        }
        $visit = $this->visit->find($request->visit_id);
        $visit->status = $request->status;
        $visit->cancel_note = $request->status == 'cancelled' ? $request->cancel_note : null;
        $visit->save();


        switch ($request->status) {
            case 'completed':
                $log_title = 'Completed Visit';
                break;
            case 'reached':
                $log_title = 'Reached Destination';
                break;
            case 'started':
                $log_title = 'Started Visit';
                break;
            case 'cancelled':
                $log_title = 'Cancelled Visit';
                break;

            default:
                $log_title = 'Visit Rescheduled';
                break;
        }
        $request['title'] = $log_title;

        $schedule = new VisitSchedule;
        $schedule->visit_id = $request->visit_id;
        $schedule->title = $request->title;
        $schedule->status = $request->status;
        $schedule->latitude = $request->latitude;
        $schedule->longitude = $request->longitude;
        if ($request->status == 'started') {
            $schedule->started_at = now();
        }
        if ($request->status == 'reached') {
            $schedule->reached_at = now();
        }

        $schedule->save();

        return $this->responseWithSuccess('Visit Status Changed Successfully', [], 200);
    }

    // new functions

    function fields()
    {
        return [
            _trans('common.No'),
            _trans('common.Nama'),
            _trans('common.Tahun'),
            _trans('common.Bulan'),
            _trans('common.File'),
            _trans('common.Aksi'),
        ];
    }
    function fields_report()
    {
        return [
            _trans('common.Id'),
            _trans('common.Employee'),
            _trans('common.Date'),
            _trans('common.Title'),
            _trans('common.Description'),
            _trans('common.Cancellation note'),
            _trans('common.File'),
            _trans('common.Status'),
        ];
    }

    function table($request)
    {
        $id_user = Auth::user()->id;
        $role = Auth::user()->role_id;

        if($role==2) {
            $data = $this->visit->query()->leftJoin('users', 'monthly_report.user_id', '=', 'users.id')->where('monthly_report.company_id', auth()->user()->company_id);
        } else {
            $data = $this->visit->query()->leftJoin('users', 'monthly_report.user_id', '=', 'users.id')->where('monthly_report.company_id', auth()->user()->company_id)->where('user_id', $id_user);
        }

        

        if ($request->from && $request->to) {
            $data = $data->whereBetween('date', start_end_datetime($request->from, $request->to));
        }
        $data->when(\request()->get('user_id'), function ($query) {
            return $query->where('user_id', \request()->get('user_id'));
        });
        $data->when(\request()->get('status'), function ($query) {
            return $query->where('status', \request()->get('status'));
        });

        if ($request->search) {
            $data = $data->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%')
                    ->orWhere('cancel_note', 'like', '%' . $request->search . '%');
            });
        }
        $data = $data->orderBy('visits.id', 'desc')->paginate(10);
        return [
            'data' => $data->map(function ($data) {
                $action_button = '';
                if (hasPermission('visit_read')) {
                    $action_button .= '<a href="' . route('visit.details', $data->id) . '" class="dropdown-item"> ' . _trans('common.Details') . '</a>';
                }

                $image = _trans('common.No File');
                if (!blank($data->visitImages)) {
                    $image_links = '';
                    foreach ($data->visitImages as $key => $image) {
                        $image_links .= '<a href="' . uploaded_asset($image->file_id) . '" download class="btn btn-white btn-sm"><i class="fas fa-download"></i></a>';
                    }
                    $image = '<p style"display:flex">' . $image_links . '</p>';
                }

                return [
                    'id'            => $data->id,
                    'name'  => @$data->name,
                    'year'  => @$data->year,
                    'month'       => @$data->month,
                    'file'       => "<a href='".url(''.$data->file.'')."' target='_blank'><i class='fa fa-file'></i></a>",
                    'action'     => actionHTML($action_button)
                ];
            }),
            'pagination' => [
                'total' => $data->total(),
                'count' => $data->count(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'total_pages' => $data->lastPage(),
                'pagination_html' =>  $data->links('backend.pagination.custom')->toHtml(),
            ],
        ];
    }
}
