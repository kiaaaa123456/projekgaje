<?php

namespace App\Http\Controllers\Drp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Laporanbulanan;
use App\Models\Periodeevkin;
use Validator;
use DB;
use Hash;
use Signature;
use Illuminate\Support\Facades\Auth;

class LaporanbulananController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();

        if($user) {

            $kdprov = Auth::user()->kdprov;
            $kdkab = Auth::user()->kdkab;
            $kdkec = Auth::user()->kdkec;
            $kddesa = Auth::user()->kddesa;
            
            if (Auth::user()->department_id==8) {
            
                $provinsi  = DB::select( DB::raw("SELECT nmprov FROM wilayah_provinsi WHERE kdprov='$kdprov'"))['0']->nmprov;
                $kab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab='$kdkab'"))['0']->nmkab;
                $kec  = DB::select( DB::raw("SELECT nmkec FROM wilayah_kecamatan WHERE kdkec='$kdkec'"))['0']->nmkec;
                $desa  = DB::select( DB::raw("SELECT nmdesa FROM wilayah_desa WHERE kddesa='$kddesa'"))['0']->nmdesa;    

            } else if (Auth::user()->department_id==7) {

                $provinsi  = DB::select( DB::raw("SELECT nmprov FROM wilayah_provinsi WHERE kdprov='$kdprov'"))['0']->nmprov;
                $kab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab='$kdkab'"))['0']->nmkab;
                $kec  = DB::select( DB::raw("SELECT nmkec FROM wilayah_kecamatan WHERE kdkec='$kdkec'"))['0']->nmkec;
                $desa  = "";    
                
            } else if (Auth::user()->department_id==6 || Auth::user()->department_id==5) {

                $provinsi  = DB::select( DB::raw("SELECT nmprov FROM wilayah_provinsi WHERE kdprov='$kdprov'"))['0']->nmprov;
                $kab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab='$kdkab'"))['0']->nmkab;
                $kec  = "";
                $desa  = "";    
                
            }

            return view('drp.fasilitator.laporanbulanan-tim-saya', compact('provinsi', 'kab', 'kec', 'desa'));
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function laporanSaya(Request $request)
    {
        $user = Auth::user();

        if($user) {

            $id_user = Auth::user()->id;
            $kdprov = Auth::user()->kdprov;
            $kdkab = Auth::user()->kdkab;
            $kdkec = Auth::user()->kdkec;
            $kddesa = Auth::user()->kddesa;

            $tahun  = DB::select( DB::raw("SELECT DISTINCT(year) FROM monthly_report WHERE user_id='$id_user'"));
            $bulan  = DB::select( DB::raw("SELECT DISTINCT(month) FROM monthly_report WHERE user_id='$id_user'"));
            
            if (Auth::user()->department_id==8) {
            
                $provinsi  = DB::select( DB::raw("SELECT nmprov FROM wilayah_provinsi WHERE kdprov='$kdprov'"))['0']->nmprov;
                $kab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab='$kdkab'"))['0']->nmkab;
                $kec  = DB::select( DB::raw("SELECT nmkec FROM wilayah_kecamatan WHERE kdkec='$kdkec'"))['0']->nmkec;
                $desa  = DB::select( DB::raw("SELECT nmdesa FROM wilayah_desa WHERE kddesa='$kddesa'"))['0']->nmdesa;    

            } else if (Auth::user()->department_id==7) {

                $provinsi  = DB::select( DB::raw("SELECT nmprov FROM wilayah_provinsi WHERE kdprov='$kdprov'"))['0']->nmprov;
                $kab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab='$kdkab'"))['0']->nmkab;
                $kec  = DB::select( DB::raw("SELECT nmkec FROM wilayah_kecamatan WHERE kdkec='$kdkec'"))['0']->nmkec;
                $desa  = "";    
                
            } else if (Auth::user()->department_id==6 || Auth::user()->department_id==5) {

                $provinsi  = DB::select( DB::raw("SELECT nmprov FROM wilayah_provinsi WHERE kdprov='$kdprov'"))['0']->nmprov;
                $kab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab='$kdkab'"))['0']->nmkab;
                $kec  = "";
                $desa  = "";    
                
            }

            return view('drp.fasilitator.laporanbulanan-saya', compact('provinsi', 'kab', 'kec', 'desa', 'tahun', 'bulan'));
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function laporanBulanan(Request $request)
    {
        $user = Auth::user();

        if($user) {
            
            $provinsi  = DB::select( DB::raw("SELECT * FROM wilayah_provinsi ORDER BY nmprov ASC"));
            return view('drp.admin.laporan-bulanan', compact('provinsi'));
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function tambahLaporan(Request $request)
    {
        $user = Auth::user();

        if($user) {

            return view('drp.fasilitator.tambah-laporan');
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function saveLaporan(Request $request)
    {
        $rules = array(
            'year'    =>  'required',
            'month'    =>  'required',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $year = $request->year;
        $month = $request->month;
        $user_id = Auth::user()->id;
        $check  = DB::select( DB::raw("SELECT * FROM monthly_report WHERE year='$year' AND month='$month' AND user_id='$user_id'"));
        if (!empty($check)) {
            return response()->json(['status' => 'exist']);
        } else {

            $profileImage = $request->file('file');
            $profileImageSaveAsName = time() . "-laporanbulanan." . 
            $profileImage->getClientOriginalExtension();
            $upload_path = 'laporanbulanan/';
            $profile_image_url = $upload_path . $profileImageSaveAsName;
            $success = $profileImage->move($upload_path, $profileImageSaveAsName);

            if (Auth::user()->department_id==8) {
                $ttd = "-";
            } else {

                $file = $request->file('file_ttdbasah');
                $file_name = time() . "-file_ttdbasah." . 
                $file->getClientOriginalExtension();
                $upload_path = 'file_ttdbasah/';
                $ttd = $upload_path . $file_name;
                $success = $file->move($upload_path, $file_name);

            }
            

            $form_data = array(

                'company_id'        => 1,
                'branch_id'        =>  1,
                'date'        =>  date('Y-m-d'),
                'year'        =>  $request->year,
                'month'        =>  $request->month,
                'file'        =>  $profile_image_url,
                'file_ttdbasah'        =>  $ttd,
                'user_id'        =>  Auth::user()->id,
                'status_visit'        =>  'created',
            );

            Laporanbulanan::create($form_data);
            return response()->json(['status' => 'success']);
        }
        
    }

    public function getLaporanTim(Request $request, $page, $limit, $month, $year)
    {
        $user = Auth::user();
        if ($month != "all" AND $year =='all') {
            $where = "AND month='$month'";
        } else if ($month == "all" AND $year !='all') {
            $where = "AND year='$year'";
        } else if ($month != "all" AND $year !='all') {
            $where = "AND month='$month' AND year='$year'";
        }  else {
            $where = "";
        }

        if($user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;
            
            if(Auth::user()->department_id==7){
                $kec = Auth::user()->kdkec;
                $data  = DB::select( DB::raw("SELECT * FROM monthly_report LEFT JOIN users ON monthly_report.user_id = users.id LEFT JOIN departments ON departments.id = users.department_id  WHERE users.kdkec = '$kec' AND department_id =8 $where ORDER BY monthly_report.id DESC LIMIT $total, $limit "));
                $count  = DB::select( DB::raw("SELECT COUNT(monthly_report.id) AS id FROM monthly_report LEFT JOIN users ON monthly_report.user_id = users.id WHERE users.kdkec = '$kec' AND department_id =8 $where"))['0']->id;
            } else if(Auth::user()->department_id==6){
                $kab = Auth::user()->kdkab;
                $data  = DB::select( DB::raw("SELECT * FROM monthly_report LEFT JOIN users ON monthly_report.user_id = users.id LEFT JOIN departments ON departments.id = users.department_id WHERE users.kdkab = '$kab' AND department_id =7 $where ORDER BY monthly_report.id DESC LIMIT $total, $limit "));
                $count  = DB::select( DB::raw("SELECT COUNT(monthly_report.id) AS id FROM monthly_report LEFT JOIN users ON monthly_report.user_id = users.id WHERE users.kdkab = '$kab' AND department_id =7 $where"))['0']->id;
            } else if(Auth::user()->department_id==5){
                $kab = Auth::user()->kdkab;
                $data  = DB::select( DB::raw("SELECT * FROM monthly_report LEFT JOIN users ON monthly_report.user_id = users.id LEFT JOIN departments ON departments.id = users.department_id WHERE users.kdkab = '$kab' AND department_id =5 $where ORDER BY monthly_report.id DESC LIMIT $total, $limit "));
                $count  = DB::select( DB::raw("SELECT COUNT(monthly_report.id) AS id FROM monthly_report LEFT JOIN users ON monthly_report.user_id = users.id WHERE users.kdkab = '$kab' AND department_id =5 $where"))['0']->id;
            }

            $total_page = ceil($count / $limit);

            if($total_page == 0) {
                $total_page = 1;
            }   

            return response()->json(['status' => 'success' ,'data' => $data, 'count' => $count, 'total_page' => $total_page, 'total' => $total]);
            
        } else {

            return redirect('sign-in');
        }
        
    } 

    public function getLaporanSaya(Request $request, $page, $limit, $month, $year)
    {
        $user = Auth::user();
        $id_user = Auth::user()->id;

        if ($month != "all" AND $year =='all') {
            $where = "WHERE user_id='$id_user' AND month='$month'";
        } else if ($month == "all" AND $year !='all') {
            $where = "WHERE user_id='$id_user' AND year='$year'";
        } else if ($month != "all" AND $year !='all') {
            $where = "WHERE user_id='$id_user' AND month='$month' AND year='$year'";
        }  else {
            $where = "WHERE user_id='$id_user'";
        }

        if($user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;
            
            $data  = DB::select( DB::raw("SELECT *, monthly_report.id AS id_main FROM monthly_report LEFT JOIN users ON monthly_report.user_id = users.id LEFT JOIN departments ON departments.id = users.department_id $where ORDER BY monthly_report.id DESC LIMIT $total, $limit "));
            $count  = DB::select( DB::raw("SELECT COUNT(monthly_report.id) AS id FROM monthly_report LEFT JOIN users ON monthly_report.user_id = users.id $where"))['0']->id;
           

            $total_page = ceil($count / $limit);

            if($total_page == 0) {
                $total_page = 1;
            }   

            return response()->json(['status' => 'success' ,'data' => $data, 'count' => $count, 'total_page' => $total_page, 'total' => $total]);
            
        } else {

            return redirect('sign-in');
        }
        
    } 

    public function getLaporanBulanan(Request $request, $page, $limit, $search, $month, $year, $kdprov, $kdkab, $kdkec, $kddesa)
    {
        $user = Auth::user();
        

        if ($search =='all' AND $month != "all" AND $year =='all' AND $kdprov== 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $where = "WHERE month='$month'";
        } else if ($search =='all' AND $month == "all" AND $year !='all' AND $kdprov== 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $where = "WHERE year='$year'";
        } else if ($search =='all' AND $month != "all" AND $year !='all' AND $kdprov== 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $where = "WHERE month='$month' AND year='$year'";
        } else if ($search =='all' AND $month != "all" AND $kdprov== 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $where = "WHERE month='$month'";
        }  else if($search =='all' AND $month != "all" AND $kdprov!= 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $where = "WHERE month='$month' AND users.kdprov='$kdprov'";
        }  else if($search =='all' AND $month != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $where = "WHERE month='$month' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab'";
        }  else if($search =='all' AND $month != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa=='all') {
            $where = "WHERE month='$month' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec'";
        } else if($search =='all' AND $month != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa!='all') {
            $where = "WHERE month='$month' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec' AND users.kddesa='$kddesa'";
        } else if ($search =='all' AND $year != "all" AND $kdprov== 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $where = "WHERE year='$year'";
        }  else if($search =='all' AND $year != "all" AND $kdprov!= 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $where = "WHERE year='$year' AND users.kdprov='$kdprov'";
        }  else if($search =='all' AND $year != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $where = "WHERE year='$year' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab'";
        }  else if($search =='all' AND $year != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa=='all') {
            $where = "WHERE year='$year' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec'";
        } else if($search =='all' AND $year != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa!='all') {
            $where = "WHERE year='$year' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec' AND users.kddesa='$kddesa'";
        } else if($search =='all' AND $month == "all" AND $kdprov!= 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa =='all') {
            $where = "WHERE users.kdprov='$kdprov'";
        } else if($search =='all' AND $month == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec == 'all' AND $kddesa =='all') {
            $where = "WHERE users.kdprov='$kdprov' AND users.kdkab='$kdkab'";
        } else if($search =='all' AND $month == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa =='all') {
            $where = "WHERE users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec'";
        } else if($search =='all' AND $month == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa !='all') {
            $where = "WHERE users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec' AND users.kddesa='$kddesa'";//
        } else if($search =='all' AND $year == "all" AND $kdprov!= 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa =='all') {
            $where = "WHERE users.kdprov='$kdprov'";
        } else if($search =='all' AND $year == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec == 'all' AND $kddesa =='all') {
            $where = "WHERE users.kdprov='$kdprov' AND users.kdkab='$kdkab'";
        } else if($search =='all' AND $year == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa =='all') {
            $where = "WHERE users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec'";
        } else if($search =='all' AND $year == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa !='all') {
            $where = "WHERE users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec' AND users.kddesa='$kddesa'";
        } else if($search =='all' AND $month != "all" AND $year != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa !='all') {
            $where = "WHERE month='$month' AND year='$year' users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec' AND users.kddesa='$kddesa'";
        } else if ($search !='all' AND $month == "all" AND $year =='all' AND $kdprov== 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $where = "WHERE users.name LIKE '%$search%'";
        } else if ($search =='all' AND $month != "all" AND $year !='all' AND $kdprov!= 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $where = "WHERE month='$month' AND year='$year' AND users.kdprov='$kdprov'";
        } else if ($search =='all' AND $month != "all" AND $year !='all' AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $where = "WHERE month='$month' AND year='$year' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab'";
        } else if ($search =='all' AND $month != "all" AND $year !='all' AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa=='all') {
            $where = "WHERE month='$month' AND year='$year' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec'";
        } else if ($search =='all' AND $month != "all" AND $year !='all' AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa!='all') {
            $where = "WHERE month='$month' AND year='$year' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec' AND users.kddesa='$kddesa'";
        } else if ($search !='all' AND $month == "all" AND $year !='all' AND $kdprov== 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $where = "WHERE year='$year' AND users.name LIKE '%$search%'";
        } else if ($search !='all' AND $month != "all" AND $year !='all' AND $kdprov== 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $where = "WHERE month='$month' AND year='$year' AND users.name LIKE '%$search%'";
        } else if ($search !='all' AND $month != "all" AND $kdprov== 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $where = "WHERE month='$month' AND users.name LIKE '%$search%'";
        }  else if($search !='all' AND $month != "all" AND $kdprov!= 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $where = "WHERE month='$month' AND users.kdprov='$kdprov' AND users.name LIKE '%$search%'";
        }  else if($search !='all' AND $month != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $where = "WHERE month='$month' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.name LIKE '%$search%'";
        }  else if($search !='all' AND $month != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa=='all') {
            $where = "WHERE month='$month' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec' AND users.name LIKE '%$search%'";
        } else if($search !='all' AND $month != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa!='all') {
            $where = "WHERE month='$month' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec' AND users.kddesa='$kddesa' AND users.name LIKE '%$search%'";
        } else if ($search !='all' AND $year != "all" AND $kdprov== 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $where = "WHERE year='$year' AND users.name LIKE '%$search%'";
        }  else if($search !='all' AND $year != "all" AND $kdprov!= 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $where = "WHERE year='$year' AND users.kdprov='$kdprov' AND users.name LIKE '%$search%'";
        }  else if($search !='all' AND $year != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $where = "WHERE year='$year' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.name LIKE '%$search%'";
        }  else if($search !='all' AND $year != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa=='all') {
            $where = "WHERE year='$year' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec' AND users.name LIKE '%$search%'";
        } else if($search !='all' AND $year != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa!='all') {
            $where = "WHERE year='$year' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec' AND users.kddesa='$kddesa' AND users.name LIKE '%$search%'";
        } else if($search !='all' AND $month == "all" AND $kdprov!= 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa =='all') {
            $where = "WHERE users.kdprov='$kdprov' AND users.name LIKE '%$search%'";
        } else if($search !='all' AND $month == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec == 'all' AND $kddesa =='all') {
            $where = "WHERE users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.name LIKE '%$search%'";
        } else if($search !='all' AND $month == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa =='all') {
            $where = "WHERE users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec' AND users.name LIKE '%$search%'";
        } else if($search !='all' AND $month == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa !='all') {
            $where = "WHERE users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec' AND users.kddesa='$kddesa' AND users.name LIKE '%$search%'";//
        } else if($search !='all' AND $year == "all" AND $kdprov!= 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa =='all') {
            $where = "WHERE users.kdprov='$kdprov' AND users.name LIKE '%$search%'";
        } else if($search !='all' AND $year == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec == 'all' AND $kddesa =='all') {
            $where = "WHERE users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.name LIKE '%$search%'";
        } else if($search !='all' AND $year == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa =='all') {
            $where = "WHERE users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec' AND users.name LIKE '%$search%'";
        } else if($search !='all' AND $year == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa !='all') {
            $where = "WHERE users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec' AND users.kddesa='$kddesa' AND users.name LIKE '%$search%'";
        } else if ($search !='all' AND $month != "all" AND $year !='all' AND $kdprov!= 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa =='all') {
            $where = "WHERE month='$month' AND year='$year' AND users.name LIKE '%$search%' AND users.kdprov='$kdprov'";
        } else if ($search !='all' AND $month != "all" AND $year !='all' AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec == 'all' AND $kddesa =='all') {
            $where = "WHERE month='$month' AND year='$year' AND users.name LIKE '%$search%' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab'";
        } else if ($search !='all' AND $month != "all" AND $year !='all' AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa =='all') {
            $where = "WHERE month='$month' AND year='$year' AND users.name LIKE '%$search%' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec'";
        } else if($search !='all' AND $month != "all" AND $year != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa !='all') {
            $where = "WHERE users.name LIKE '%$search%' AND month='$month' AND year='$year' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec' AND users.kddesa='$kddesa'";
        } else {
            $where = '';
        }

        if($user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;
            
            $data  = DB::select( DB::raw("SELECT *, monthly_report.id AS id_main FROM monthly_report LEFT JOIN users ON monthly_report.user_id = users.id LEFT JOIN departments ON departments.id = users.department_id  LEFT JOIN wilayah_provinsi ON users.kdprov = wilayah_provinsi.kdprov LEFT JOIN wilayah_kabupaten ON users.kdkab=wilayah_kabupaten.kdkab LEFT JOIN wilayah_kecamatan ON users.kdkec = wilayah_kecamatan.kdkec LEFT JOIN wilayah_desa ON users.kddesa = wilayah_desa.kddesa $where ORDER BY monthly_report.year DESC LIMIT $total, $limit "));
            $count  = DB::select( DB::raw("SELECT COUNT(monthly_report.id) AS id FROM monthly_report LEFT JOIN users ON monthly_report.user_id = users.id $where"))['0']->id;
           

            $total_page = ceil($count / $limit);

            if($total_page == 0) {
                $total_page = 1;
            }   

            return response()->json(['status' => 'success' ,'data' => $data, 'count' => $count, 'total_page' => $total_page, 'total' => $total]);
            
        } else {

            return redirect('sign-in');
        }
        
    } 

    public function editLaporan($id)
    {
        $user = Auth::user();

        if($user) {

             $laporan  = DB::select( DB::raw("SELECT * FROM monthly_report WHERE md5(id)='$id'"));

            return view('drp.fasilitator.edit-laporan', compact('laporan'));
            
        } else {

            return redirect('sign-in');
        }
        
    }

    
    public function updateLaporan(Request $request)
    {
        $rules = array(
            'year'    =>  'required',
            'month'    =>  'required',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $year = $request->year;
        $month = $request->month;
        $user_id = Auth::user()->id;
        $check  = DB::select( DB::raw("SELECT * FROM monthly_report WHERE year='$year' AND month='$month' AND user_id='$user_id'"));
        

        $file = $request->file('file');
        $file_ttd = $request->file('file_ttdbasah');

        if (empty($file) && empty($file_ttd)) {
            
            $form_data = array(

                'company_id'        => 1,
                'branch_id'        =>  1,
                'date'        =>  date('Y-m-d'),
                'year'        =>  $request->year,
                'month'        =>  $request->month,
                'user_id'        =>  Auth::user()->id,
                'status_visit'        =>  'created',
            );

        } else if (empty($file) && !empty($file_ttd)) {
            
            $file_name_ttd = time() . "-file_ttdbasah." . 
            $file_ttd->getClientOriginalExtension();
            $upload_path = 'file_ttdbasah/';
            $ttd = $upload_path . $file_name_ttd;
            $success = $file_ttd->move($upload_path, $file_name_ttd);

            $form_data = array(

                'company_id'        => 1,
                'branch_id'        =>  1,
                'date'        =>  date('Y-m-d'),
                'year'        =>  $request->year,
                'month'        =>  $request->month,
                'file_ttdbasah'        =>  $ttd,
                'user_id'        =>  Auth::user()->id,
                'status_visit'        =>  'created',
            );

        } else if (empty($file_ttd) && !empty($file)) {
            
            $file_name = time() . "-laporanbulanan." . 
            $file->getClientOriginalExtension();
            $upload_path = 'laporanbulanan/';
            $file_lapbul = $upload_path . $file_name;
            $success = $file->move($upload_path, $file_name);

            $form_data = array(

                'company_id'        => 1,
                'branch_id'        =>  1,
                'date'        =>  date('Y-m-d'),
                'year'        =>  $request->year,
                'month'        =>  $request->month,
                'file'        =>  $file_lapbul,
                'user_id'        =>  Auth::user()->id,
                'status_visit'        =>  'created',
            );

        } else {

            $file_name = time() . "-laporanbulanan." . 
            $file->getClientOriginalExtension();
            $upload_path = 'laporanbulanan/';
            $file_lapbul = $upload_path . $file_name;
            $success = $file->move($upload_path, $file_name);


            $file_name_ttd = time() . "-file_ttdbasah." . 
            $file_ttd->getClientOriginalExtension();
            $upload_path = 'file_ttdbasah/';
            $ttd = $upload_path . $file_name_ttd;
            $success = $file_ttd->move($upload_path, $file_name_ttd);

            $form_data = array(

                'company_id'        => 1,
                'branch_id'        =>  1,
                'date'        =>  date('Y-m-d'),
                'year'        =>  $request->year,
                'month'        =>  $request->month,
                'file'        =>  $file_lapbul,
                'file_ttdbasah'        =>  $ttd,
                'user_id'        =>  Auth::user()->id,
                'status_visit'        =>  'created',
            );
        }
        

        Laporanbulanan::whereId($request->hidden_id)->update($form_data);
        return response()->json(['status' => 'success']);
    }

    public function laporanKorkab(Request $request)
    {
        $user = Auth::user();

        if($user) {

            $kdkab = Auth::user()->kdkab;
            $nmkab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab='$kdkab'"))['0']->nmkab;

            return view('drp.admin.laporanbulanan-korkab', compact('nmkab'));
            
        } else {

            return redirect('sign-in');
        }
        
    }


    public function getlaporanKorkab(Request $request, $page, $limit, $month, $year)
    {
        $user = Auth::user();
        if ($month != "all" AND $year =='all') {
            $where = "AND month='$month'";
        } else if ($month == "all" AND $year !='all') {
            $where = "AND year='$year'";
        } else if ($month != "all" AND $year !='all') {
            $where = "AND month='$month' AND year='$year'";
        }  else {
            $where = "";
        }

        if($user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;

            $kdkab = Auth::user()->kdkab;
            $data  = DB::select( DB::raw("SELECT * FROM monthly_report LEFT JOIN users ON monthly_report.user_id = users.id LEFT JOIN departments ON departments.id = users.department_id  WHERE users.kdkab = '$kdkab' AND department_id =5 $where ORDER BY monthly_report.id DESC LIMIT $total, $limit "));
            $count  = DB::select( DB::raw("SELECT COUNT(monthly_report.id) AS id FROM monthly_report LEFT JOIN users ON monthly_report.user_id = users.id WHERE users.kdkab = '$kdkab' AND department_id =5 $where"))['0']->id;

            $total_page = ceil($count / $limit);

            if($total_page == 0) {
                $total_page = 1;
            }   

            return response()->json(['status' => 'success' ,'data' => $data, 'count' => $count, 'total_page' => $total_page, 'total' => $total]);
            
        } else {

            return redirect('sign-in');
        }
        
    } 

    public function laporanFaskab(Request $request)
    {
        $user = Auth::user();

        if($user) {

            $kdkab = Auth::user()->kdkab;
            $nmkab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab='$kdkab'"))['0']->nmkab;

            return view('drp.admin.laporanbulanan-faskab', compact('nmkab'));
            
        } else {

            return redirect('sign-in');
        }
        
    }


    public function getlaporanFaskab(Request $request, $page, $limit, $month, $year)
    {
        $user = Auth::user();
        if ($month != "all" AND $year =='all') {
            $where = "AND month='$month'";
        } else if ($month == "all" AND $year !='all') {
            $where = "AND year='$year'";
        } else if ($month != "all" AND $year !='all') {
            $where = "AND month='$month' AND year='$year'";
        }  else {
            $where = "";
        }

        if($user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;

            $kdkab = Auth::user()->kdkab;
            $data  = DB::select( DB::raw("SELECT * FROM monthly_report LEFT JOIN users ON monthly_report.user_id = users.id LEFT JOIN departments ON departments.id = users.department_id  WHERE users.kdkab = '$kdkab' AND department_id =6 $where ORDER BY monthly_report.id DESC LIMIT $total, $limit "));
            $count  = DB::select( DB::raw("SELECT COUNT(monthly_report.id) AS id FROM monthly_report LEFT JOIN users ON monthly_report.user_id = users.id WHERE users.kdkab = '$kdkab' AND department_id =6 $where"))['0']->id;

            $total_page = ceil($count / $limit);

            if($total_page == 0) {
                $total_page = 1;
            }   

            return response()->json(['status' => 'success' ,'data' => $data, 'count' => $count, 'total_page' => $total_page, 'total' => $total]);
            
        } else {

            return redirect('sign-in');
        }
        
    } 

    public function laporanFasdis(Request $request)
    {
        $user = Auth::user();

        if($user) {

            $kdkab = Auth::user()->kdkab;
            $nmkab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab='$kdkab'"))['0']->nmkab;

            return view('drp.admin.laporanbulanan-fasdis', compact('nmkab'));
            
        } else {

            return redirect('sign-in');
        }
        
    }


    public function getlaporanFasdis(Request $request, $page, $limit, $month, $year)
    {
        $user = Auth::user();
        if ($month != "all" AND $year =='all') {
            $where = "AND month='$month'";
        } else if ($month == "all" AND $year !='all') {
            $where = "AND year='$year'";
        } else if ($month != "all" AND $year !='all') {
            $where = "AND month='$month' AND year='$year'";
        }  else {
            $where = "";
        }

        if($user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;

            $kdkab = Auth::user()->kdkab;
            $data  = DB::select( DB::raw("SELECT * FROM monthly_report LEFT JOIN users ON monthly_report.user_id = users.id LEFT JOIN departments ON departments.id = users.department_id LEFT JOIN wilayah_kecamatan ON wilayah_kecamatan.kdkec = users.kdkec  WHERE users.kdkab = '$kdkab' AND department_id =7 $where ORDER BY monthly_report.id DESC LIMIT $total, $limit "));
            $count  = DB::select( DB::raw("SELECT COUNT(monthly_report.id) AS id FROM monthly_report LEFT JOIN users ON monthly_report.user_id = users.id WHERE users.kdkab = '$kdkab' AND department_id =7 $where"))['0']->id;

            $total_page = ceil($count / $limit);

            if($total_page == 0) {
                $total_page = 1;
            }   

            return response()->json(['status' => 'success' ,'data' => $data, 'count' => $count, 'total_page' => $total_page, 'total' => $total]);
            
        } else {

            return redirect('sign-in');
        }
        
    } 

    public function laporanKader(Request $request)
    {
        $user = Auth::user();

        if($user) {

            $kdkab = Auth::user()->kdkab;
            $nmkab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab='$kdkab'"))['0']->nmkab;

            return view('drp.admin.laporanbulanan-kader', compact('nmkab'));
            
        } else {

            return redirect('sign-in');
        }
        
    }


    public function getlaporanKader(Request $request, $page, $limit, $month, $year)
    {
        $user = Auth::user();
        if ($month != "all" AND $year =='all') {
            $where = "AND month='$month'";
        } else if ($month == "all" AND $year !='all') {
            $where = "AND year='$year'";
        } else if ($month != "all" AND $year !='all') {
            $where = "AND month='$month' AND year='$year'";
        }  else {
            $where = "";
        }

        if($user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;

            $kdkab = Auth::user()->kdkab;
            $kdkec = Auth::user()->kdkec;

            if (Auth::user()->department_id==7) {

                $data  = DB::select( DB::raw("SELECT * FROM monthly_report LEFT JOIN users ON monthly_report.user_id = users.id LEFT JOIN departments ON departments.id = users.department_id LEFT JOIN wilayah_kecamatan ON wilayah_kecamatan.kdkec = users.kdkec LEFT JOIN wilayah_desa ON wilayah_desa.kddesa = users.kddesa  WHERE users.kdkab = '$kdkab' AND users.kdkec = '$kdkec' AND department_id =8 $where ORDER BY monthly_report.id DESC LIMIT $total, $limit "));
                $count  = DB::select( DB::raw("SELECT COUNT(monthly_report.id) AS id FROM monthly_report LEFT JOIN users ON monthly_report.user_id = users.id WHERE users.kdkab = '$kdkab' AND users.kdkec = '$kdkec' AND department_id =8 $where"))['0']->id;

            } else {

                $data  = DB::select( DB::raw("SELECT * FROM monthly_report LEFT JOIN users ON monthly_report.user_id = users.id LEFT JOIN departments ON departments.id = users.department_id LEFT JOIN wilayah_kecamatan ON wilayah_kecamatan.kdkec = users.kdkec LEFT JOIN wilayah_desa ON wilayah_desa.kddesa = users.kddesa  WHERE users.kdkab = '$kdkab' AND department_id =8 $where ORDER BY monthly_report.id DESC LIMIT $total, $limit "));
                $count  = DB::select( DB::raw("SELECT COUNT(monthly_report.id) AS id FROM monthly_report LEFT JOIN users ON monthly_report.user_id = users.id WHERE users.kdkab = '$kdkab' AND department_id =8 $where"))['0']->id;

            }

            

            $total_page = ceil($count / $limit);

            if($total_page == 0) {
                $total_page = 1;
            }   

            return response()->json(['status' => 'success' ,'data' => $data, 'count' => $count, 'total_page' => $total_page, 'total' => $total]);
            
        } else {

            return redirect('sign-in');
        }
        
    } 

    public function deleteLaporanBulanan(Request $request) {

        $id = $request->id_delete;
        $delete  = DB::select( DB::raw("DELETE FROM  monthly_report WHERE id='$id'"));
        return response()->json(['status' => 'success']);
    }
}

    