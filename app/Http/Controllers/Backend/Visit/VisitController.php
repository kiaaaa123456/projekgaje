<?php

namespace App\Http\Controllers\Backend\Visit;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Repositories\Hrm\Visit\VisitRepository;
use App\Models\coreApp\Relationship\RelationshipTrait;
use App\Models\Visit\VisitSchedule;
use App\Repositories\Hrm\Department\DepartmentRepository;
use App\Models\Hrm\Visit\Visit;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;

class VisitController extends Controller
{

    // use RelationshipTrait;
    // protected $departmentRepository;
    // protected $visitRepository;

    // public function __construct(DepartmentRepository $departmentRepository, VisitRepository $visitRepository)
    // {
    //     $this->departmentRepository = $departmentRepository;
    //     $this->visitRepository = $visitRepository;
    // }

    use ApiReturnFormatTrait;

    protected $visit;

    public function __construct(VisitRepository $repository)
    {
        $this->visit = $repository;

    }

    

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->visit->table($request);
        }
        $data['fields'] = $this->visit->fields();
        $data['table']    = route('visit.index');
        $data['url_id']    = 'visit_table_url';
        $data['class']     = 'visit_table';
        $data['title'] = _trans('common.Laporan Bulanan');
        return view('backend.visit.index', compact('data'));
    }

    public function create()
    {
        $data['title'] = _trans('visit.Input Laporan Bulanan');
        $data['id'] = auth()->id();
        return view('backend.visit.create', compact('data'));
    }

    public function store(Request $request)
    {
        if (appMode()) {
            Toastr::error(_trans('message.You cannot do it for demo'), 'Error');
            return redirect()->back();
        }
        $ticket = $this->visit->store($request);
        try {
            if ($ticket->original['result']) {
                Toastr::success(_trans('response.Laporan bulanan berhasil dibuat'), 'Success');
            } else {
                Toastr::error($ticket->original['message'], 'Error');
            }
            return redirect()->route('visit.index');
        } catch (\Throwable $throwable) {
            Toastr::error(_trans('response.Ada kesalahan sepertinya silakan coba lagi'), 'Error');
            return redirect()->back();
        }
    }

    public function reports(Request $request)
    {
        if ($request->ajax()) {
            return $this->visitRepository->table($request);
        }
        $data['fields'] = $this->visitRepository->fields_report();
        $data['checkbox'] = true;
        $data['table']    = route('report_visit.index');
        $data['url_id']    = 'visit_report_table_url';
        $data['class']     = 'table_class';


        $data['title'] = _trans('common.Visit Reports');
        $data['departments'] = $this->departmentRepository->getAll();
        $data['visits'] = $this->visitRepository->getAll();
        return view('backend.visit.reports', compact('data'));
    }

    public function visit($id)
    {
        try {
            $data['id'] = $id;
            $data['title'] = _trans('common.Visit List');
            return view('backend.user.visit', compact('data'));
        } catch (\Exception $exception) {
            Toastr::error('Something went wrong.', 'Error');
        }
    }

    public function visitDatatable(Request $request, $userId)
    {
        try {
            return $this->visitRepository->getListForWeb($request, $userId);
        } catch (\Exception $e) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }

    public function visitHistory($id)
    {
        try {
            $data['id'] = $id;
            $data['title'] = _trans('common.Visit History');
            return view('backend.user.visit_history', compact('data'));
        } catch (\Exception $exception) {
            Toastr::error('Something went wrong.', 'Error');
        }
    }

    public function visitHistoryDatatable(Request $request)
    {
        try {
            return $this->visitRepository->visitHistoryDatatable($request, 'visit_history');
        } catch (\Exception $e) {
            Toastr::error(_trans('response.Something went wrong.'), 'Error');
            return redirect()->back();
        }
    }

    public function visitDetails($id)
    {
        try {
            $data['title'] = _trans('common.Visit Details');
            $data['visit'] = $this->visitRepository->getVisitDetails($id);
            return view('backend.visit.visit_details', compact('data'));
        } catch (\Throwable $exception) {
            Toastr::error('Something went wrong.', 'Error');
            return redirect()->back();
        }
    }


    public function userProfileTable(Request $request)
    {
        if ($request->ajax()) {
            return $this->visitRepository->table($request);
        }
    }
}
