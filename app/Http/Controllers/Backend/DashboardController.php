<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Services\Task\TaskService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Repositories\DashboardRepository;
use App\Services\Management\ProjectService;
use App\Repositories\Hrm\Payroll\SalaryRepository;
use App\Repositories\Hrm\Finance\ExpenseRepository;
use App\Repositories\Hrm\Expense\HrmExpenseRepository;
use App\Repositories\Hrm\Attendance\AttendanceRepository;
use App\Repositories\Hrm\Department\DepartmentRepository;
use DB;


class DashboardController extends Controller
{
    protected $dashboardRepository;
    protected $attendanceRepo;
    protected $expenseRepo;
    protected $expenseNewRepo;
    protected $departmentRepo;
    protected $salaryRepository;
    protected $taskService;
    protected $projectService;



    public function __construct(
        DashboardRepository $dashboardRepository,
        AttendanceRepository $attendanceRepo,
        HrmExpenseRepository $expenseRepo,
        ExpenseRepository $expenseNewRepo,
        DepartmentRepository $departmentRepo,
        SalaryRepository $salaryRepository,
        TaskService $taskService,
        ProjectService $projectService
    ) {
        $this->dashboardRepository = $dashboardRepository;
        $this->attendanceRepo = $attendanceRepo;
        $this->expenseRepo = $expenseRepo;
        $this->expenseNewRepo = $expenseNewRepo;
        $this->departmentRepo = $departmentRepo;
        $this->salaryRepository = $salaryRepository;
        $this->taskService = $taskService;
        $this->projectService = $projectService;
    }

    public function loadMyProfileDashboard($request)
    {
        try {

            $request['month'] = date('Y-m');

            $menus = $this->dashboardRepository->getNewDashboardStatistics($request);
            $data['dashboardMenus'] = @$menus->original['data'];

            return $returnHTML = view('backend.dashboard.load_my_dashboard', compact('data'))->render();
            return $returnHTML = view('backend.dashboard.loadProfileDashboard', compact('data'))->render();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function loadCompanyDashboard($request)
    {
        try {
            $request['month'] = date('Y-m');

            $menus = $this->dashboardRepository->getNewCompanyDashboardStatistics($request);
            $data['dashboardMenus'] = @$menus->original['data'];
            return $returnHTML = view('backend.dashboard.load_company_dashboard', compact('data'))->render();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function loadSuperadminDashboard($request)
    {
        try {
            $request['month'] = date('Y-m');
            $menus = $this->dashboardRepository->getDashboardStatistics($request);
            $data['dashboardMenus'] = @$menus->original['data'];
            $companyMenus = $this->dashboardRepository->getCompanyDashboardStatistics($request);
            $data['companyMenus'] = @$companyMenus->original['data'];
            return $returnHTML = view('backend.dashboard.loadSuperadminDashboard', compact('data'))->render();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function profileWiseDashboard(Request $request)
    {
        $user = Auth::user();
        $dashboard = '';
        $date = date('Y-m-d');
        switch ($request->dashboardType) {

            case 'My Dashboard':
                $dashboard = $this->loadMyProfileDashboard($request);
                $data['dashboardType'] = 'Dashboard';
                // $data['project']            = $this->dashboardRepository->getProjectDashboard(auth()->id());
                // $data['task']               = $this->dashboardRepository->getTaskDashboard(auth()->id());
                // $data['appointment']        = $this->dashboardRepository->getAppointmentDashboard(auth()->id());
                // $data['meeting']            = $this->dashboardRepository->getMeetingDashboard(auth()->id());
                break;
            case 'Company Dashboard':
                $dashboard = $this->loadCompanyDashboard($request);
                $data['dashboardType'] = 'Company Dashboard';
                // $data['expense']            = $this->expenseNewRepo->getMonthlyExpense($request);
                // $data['attendance_summary'] = $this->attendanceRepo->getTodayAttendanceDashboard($date);
                // $data['payroll']            = $this->salaryRepository->getMonthlyPayroll();
                // // $data['project']            = $this->dashboardRepository->getProjectDashboard();
                // $data['task']               = $this->dashboardRepository->getTaskDashboard();
                // $data['appointment']        = $this->dashboardRepository->getAppointmentDashboard();
                // $data['meeting']            = $this->dashboardRepository->getMeetingDashboard();

                break;
            case 'Superadmin Dashboard':
                $dashboard = $this->loadSuperadminDashboard($request);
                $data['dashboardType'] = 'Super Admin';
                break;
        }
        $data['dashboard'] = $dashboard;
        $data['status'] = 'success';
        $data['message'] = 'Dashboard loaded successfully';
        return $data;
    }

    public function companyDashboard()
    {
        $request['month'] = date('Y-m');
        $menus = $this->dashboardRepository->getDashboardStatistics($request);
        $data['dashboardMenus'] = @$menus->original['data'];
        $companyMenus = $this->dashboardRepository->getCompanyDashboardStatistics($request);
        $data['companyMenus'] = @$companyMenus->original['data'];
        $attendance_data = $this->attendanceRepo->getCheckInCheckoutStatus(auth()->user()->id);
        $data['attendance'] = @$attendance_data->original['data'];
        $company_today_attendance = $this->attendanceRepo->getTodayAttendance(date('Y-m-d'));
        $data['company_today_attendance'] = $company_today_attendance;

        return $data;
    }

    public function superadminDashboard()
    {
        $request['month'] = date('Y-m');
        $menus = $this->dashboardRepository->getSuperadminDashboardStatistic($request);
        $data['dashboardMenus'] = @$menus->original['data'];


        return $data;
    }

    public function index(Request $request)
    {

        try {
            if (auth()->user()->role_id == 1) {
                $data = $this->superadminDashboard();
                return view('backend.__superadmin_dashboard', compact('data'));
            } else {
                if (!config('settings.app')['site_under_maintenance']) {

                    $data = $this->companyDashboard();
                    
                    if(Auth::user()->is_admin == 1) {

                        $korkab  = DB::select( DB::raw("SELECT count(id) AS id FROM users WHERE department_id = 5"))['0']->id;
                        $faskab  = DB::select( DB::raw("SELECT count(id) AS id FROM users WHERE department_id = 6"))['0']->id;
                        $faskec  = DB::select( DB::raw("SELECT count(id) AS id FROM users WHERE department_id = 7"))['0']->id;
                        $kader  = DB::select( DB::raw("SELECT count(id) AS id FROM users WHERE department_id = 8"))['0']->id;
                        $daily  = DB::select( DB::raw("SELECT count(id) AS id FROM daily_activity"))['0']->id;
                        $monthly  = DB::select( DB::raw("SELECT count(id) AS id FROM monthly_report"))['0']->id;
                        $absensi  = DB::select( DB::raw("SELECT count(id) AS id FROM attendances"))['0']->id;
                        $leave  = DB::select( DB::raw("SELECT count(id) AS id FROM leave_requests"))['0']->id;
                        $daily_recent  = DB::select( DB::raw("SELECT daily_activity.title AS rencana, description, location, name, departments.title FROM daily_activity LEFT JOIN users ON daily_activity.created_by = users.id LEFT JOIN departments ON users.department_id = departments.id ORDER BY daily_activity.id DESC LIMIT 10"));
                        
                        return view('backend.dashboard', compact('data', 'korkab', 'faskab', 'faskec', 'kader', 'daily', 'monthly', 'absensi', 'leave', 'daily_recent'));

                    } else {

                        if (Auth::user()->department_id==5 || Auth::user()->department_id==6 || Auth::user()->department_id==7 || Auth::user()->department_id==8) {
                            
                            $id = Auth::user()->id;
                            $month =  date('m');
                            $year =  date('Y');
                            $daily  = DB::select( DB::raw("SELECT count(id) AS id FROM daily_activity WHERE created_by='$id' AND MONTH(date) = '$month'"))['0']->id;
                            $monthly  = DB::select( DB::raw("SELECT count(id) AS id FROM monthly_report WHERE user_id='$id' AND year='$year'"))['0']->id;
                            $absensi  = DB::select( DB::raw("SELECT count(id) AS id FROM attendances WHERE user_id='$id' AND check_in IS NOT NULL AND check_out IS NOT NULL AND MONTH(date)='$month'"))['0']->id;
                            // $leave  = DB::select( DB::raw("SELECT count(id) AS id FROM leave_requests WHERE user_id='$id' AND MONTH(created_at)='$month' AND status_id=1"))['0']->id;
                            $leave_  = DB::select( DB::raw("SELECT SUM(days) AS total FROM leave_requests WHERE user_id='$id' AND MONTH(created_at)='$month' AND status_id=1"))['0']->total;
                            if (empty($leave_)) {
                                $leave = 0;
                            } else {
                                $leave = $leave_;
                            }
                            $daily_recent  = DB::select( DB::raw("SELECT daily_activity.title AS rencana, description, location, name, departments.title FROM daily_activity LEFT JOIN users ON daily_activity.created_by = users.id LEFT JOIN departments ON users.department_id = departments.id WHERE created_by='$id' ORDER BY daily_activity.id DESC LIMIT 5"));
                            $monthly_recent  = DB::select( DB::raw("SELECT month,year,file FROM monthly_report  WHERE user_id='$id' ORDER BY monthly_report.id DESC LIMIT 5"));
                            
                            return view('backend.dashboard_fasilitator', compact('data', 'daily', 'monthly', 'absensi', 'leave', 'daily_recent', 'monthly_recent'));

                        } else if (Auth::user()->department_id==27 || Auth::user()->department_id==33 || Auth::user()->department_id==31) {

                            $kdkab = Auth::user()->kdkab;

                            $korkab  = DB::select( DB::raw("SELECT count(id) AS id FROM users WHERE department_id = 5 AND kdkab='$kdkab'"))['0']->id;

                            $faskab  = DB::select( DB::raw("SELECT count(id) AS id FROM users WHERE department_id = 6 AND kdkab='$kdkab'"))['0']->id;
                            $faskec  = DB::select( DB::raw("SELECT count(id) AS id FROM users WHERE department_id = 7 AND kdkab='$kdkab'"))['0']->id;
                            $kader  = DB::select( DB::raw("SELECT count(id) AS id FROM users WHERE department_id = 8 AND kdkab='$kdkab'"))['0']->id;
                            
                            
                            $daily_recent  = DB::select( DB::raw("SELECT daily_activity.title AS rencana, description, location, name, departments.title FROM daily_activity LEFT JOIN users ON daily_activity.created_by = users.id LEFT JOIN departments ON users.department_id = departments.id WHERE users.kdkab='$kdkab' ORDER BY daily_activity.id DESC LIMIT 10"));
                            
                            return view('backend.dashboard_tpk_korwil', compact('data', 'korkab', 'faskab', 'faskec', 'kader', 'daily_recent'));
                        } 


                        
                    }                    

                    

                } else {
                    return redirect('/');
                }
            }
        } catch (\Exception $e) {
            Toastr::error(_trans('response.Something went wrong!'), 'Error');
            return redirect()->back();
        }
    }


    public function currentMonthPieChart(Request $request)
    {
        $request['month'] = date('Y-m');
        return $this->expenseRepo->getMonthlyExpense();
    }

    public function incomeExpenseGraph(Request $request)
    {
        try {
            return $this->dashboardRepository->getIncomeExpenseGraph($request);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function statistics(Request $request)
    {
        try {
            return $this->dashboardRepository->getDashboardStatistics($request);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('adminLogin');
    }
}
