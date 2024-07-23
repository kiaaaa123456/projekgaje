<?php

namespace App\Http\Controllers\Drp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Aktivitasharian;
use App\Models\Attendance;
use Validator;
use DB;
use App\Models\User;
use Hash;
use Signature;
use Illuminate\Support\Facades\Auth;

class AktivitasharianController extends Controller
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

            return view('drp.fasilitator.aktivitas-harian-tim', compact('provinsi', 'kab', 'kec', 'desa'));
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function aktivitasSaya(Request $request)
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

            return view('drp.fasilitator.aktivitas-harian-saya', compact('provinsi', 'kab', 'kec', 'desa'));
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function aktivitasHarian(Request $request)
    {
        $user = Auth::user();

        if($user) {

            $provinsi  = DB::select( DB::raw("SELECT * FROM wilayah_provinsi ORDER BY nmprov ASC"));
            return view('drp.admin.aktivitas-harian', compact('provinsi'));
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function tambahAktivitas(Request $request)
    {
        
        $user = Auth::user();

        if($user) {

            return view('drp.fasilitator.tambah-aktivitas-harian');
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function saveAktivitas(Request $request)
    {
        $rules = array(
            'title'    =>  'required',
            'description'    =>  'required',
            // 'location'    =>  'required',
            'latitude'    =>  'required',
            'longitude'    =>  'required',
            'date'    =>  'required',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $profileImage = $request->file('file');
        $profileImageSaveAsName = time() . "-aktivitasharian." . 
        $profileImage->getClientOriginalExtension();
        $upload_path = 'aktivitasharian/';
        $profile_image_url = $upload_path . $profileImageSaveAsName;
        $success = $profileImage->move($upload_path, $profileImageSaveAsName);

        $form_data = array(
            'created_by'        =>  Auth::user()->id,
            'file'        =>  $profile_image_url,
            'title'        =>  $request->title,
            'description'        =>  $request->description,
            'location'        =>  getGeocodeData($request->latitude, $request->longitude),
            'latitude'        =>  $request->latitude,
            'longitude'        =>  $request->longitude,
            'date'        =>  date("Y-m-d", strtotime($request->date)),
            'appoinment_start_at'        =>  $request->appoinment_start_at,
            'appoinment_end_at'        =>  $request->appoinment_end_at,
            'appoinment_with'        => 1,
            'company_id'        => 1,
            'status_id'        =>  1,
            'branch_id'        =>  1,
        );

        Aktivitasharian::create($form_data);
        return response()->json(['status' => 'success']);
        
    }

    public function getAktivitasTim(Request $request, $page, $limit, $date)
    {
        $user = Auth::user();

        // if ($search != "all" AND $date != "all") {
        //     $date = date("Y-m-d", strtotime($date));
        //     $where = "AND daily_activity.title LIKE '%" . $search . "%' AND DATE(daily_activity.date)='$date'";
        // } else if ($search != "all" AND $date == "all") {
        //     $where = "AND daily_activity.title LIKE '%" . $search . "%'";
        // } else if ($search == "all" AND $date != "all") {
        //     $date = date("Y-m-d", strtotime($date));
        //     $where = "AND DATE(daily_activity.date)='$date'";
        // } else {
        //     $where = "";
        // }


        if ($date != "all") {
            $date = date("Y-m-d", strtotime($date));
            $where = "AND DATE(daily_activity.date)='$date'";
        } else {
            $where = "";
        }



        if($user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;

            // $data  = DB::select( DB::raw("SELECT * FROM periode_evkin  ORDER BY id DESC LIMIT $total, $limit "));
            // $count  = DB::select( DB::raw("SELECT COUNT(id) AS id FROM periode_evkin"))['0']->id;
            if(Auth::user()->department_id==7){
                $kec = Auth::user()->kdkec;
                $data  = DB::select( DB::raw("SELECT *, daily_activity.title AS rencana, daily_activity.date AS tgl FROM daily_activity LEFT JOIN users ON daily_activity.created_by = users.id LEFT JOIN departments ON departments.id = users.department_id  WHERE users.kdkec = '$kec' AND department_id =8 $where  ORDER BY daily_activity.id DESC LIMIT $total, $limit "));
                $count  = DB::select( DB::raw("SELECT COUNT(daily_activity.id) AS id FROM daily_activity LEFT JOIN users ON daily_activity.created_by = users.id WHERE users.kdkec = '$kec' AND department_id =8 $where "))['0']->id;
            } else if(Auth::user()->department_id==6){
                $kab = Auth::user()->kdkab;
                $data  = DB::select( DB::raw("SELECT *, daily_activity.title AS rencana, daily_activity.date AS tgl  FROM daily_activity LEFT JOIN users ON daily_activity.created_by = users.id LEFT JOIN departments ON departments.id = users.department_id WHERE users.kdkab = '$kab' AND department_id =7 $where ORDER BY daily_activity.id DESC LIMIT $total, $limit "));
                $count  = DB::select( DB::raw("SELECT COUNT(daily_activity.id) AS id FROM daily_activity LEFT JOIN users ON daily_activity.created_by = users.id WHERE users.kdkab = '$kab' AND department_id =7 $where"))['0']->id;
            } else if(Auth::user()->department_id==5){
                $kab = Auth::user()->kdkab;
                $data  = DB::select( DB::raw("SELECT *, daily_activity.title AS rencana, daily_activity.date AS tgl  FROM daily_activity LEFT JOIN users ON daily_activity.created_by = users.id LEFT JOIN departments ON departments.id = users.department_id WHERE users.kdkab = '$kab' AND department_id =6 $where ORDER BY daily_activity.id DESC LIMIT $total, $limit "));
                $count  = DB::select( DB::raw("SELECT COUNT(daily_activity.id) AS id FROM daily_activity LEFT JOIN users ON daily_activity.created_by = users.id WHERE users.kdkab = '$kab' AND department_id =6 $where"))['0']->id;
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


    public function getAktivitasSaya(Request $request, $page, $limit, $date)
    {
        $id_user = Auth::user()->id;

        if ($date != "all") {
            $date = date("Y-m-d", strtotime($date));
            $where = "WHERE created_by='$id_user' AND DATE(daily_activity.date)='$date'";
        } else {
            $where = "WHERE created_by='$id_user'";
        }

        if($id_user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;            
            
            $data  = DB::select( DB::raw("SELECT *, daily_activity.title AS rencana, daily_activity.date AS tgl, daily_activity.id AS id_main FROM daily_activity LEFT JOIN users ON daily_activity.created_by = users.id LEFT JOIN departments ON departments.id = users.department_id  $where  ORDER BY daily_activity.id DESC LIMIT $total, $limit "));
            $count  = DB::select( DB::raw("SELECT COUNT(daily_activity.id) AS id FROM daily_activity LEFT JOIN users ON daily_activity.created_by = users.id $where "))['0']->id;
            

            $total_page = ceil($count / $limit);

            if($total_page == 0) {
                $total_page = 1;
            }   

            return response()->json(['status' => 'success' ,'data' => $data, 'count' => $count, 'total_page' => $total_page, 'total' => $total]);
            
        } else {

            return redirect('sign-in');
        }
        
    } 

    public function getAktivitasHarian(Request $request, $page, $limit, $search, $date, $kdprov, $kdkab, $kdkec, $kddesa)
    {
        $id_user = Auth::user()->id;
        
        if ($search =='all' AND $date != "all" AND $kdprov== 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $date = date("Y-m-d", strtotime($date));
            $where = "WHERE DATE(daily_activity.date)='$date'";
        }  else if($search =='all' AND $date != "all" AND $kdprov!= 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $date = date("Y-m-d", strtotime($date));
            $where = "WHERE DATE(daily_activity.date)='$date' AND users.kdprov='$kdprov'";
        }  else if($search =='all' AND $date != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $date = date("Y-m-d", strtotime($date));
            $where = "WHERE DATE(daily_activity.date)='$date' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab'";
        }  else if($search =='all' AND $date != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa=='all') {
            $date = date("Y-m-d", strtotime($date));
            $where = "WHERE DATE(daily_activity.date)='$date' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec'";
        } else if($search =='all' AND $date != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa!='all') {
            $date = date("Y-m-d", strtotime($date));
            $where = "WHERE DATE(daily_activity.date)='$date' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec' AND users.kddesa='$kddesa'";
        } else if($search =='all' AND $date == "all" AND $kdprov!= 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa =='all') {
            $where = "WHERE users.kdprov='$kdprov'";
        } else if($search =='all' AND $date == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec == 'all' AND $kddesa =='all') {
            $where = "WHERE users.kdprov='$kdprov' AND users.kdkab='$kdkab'";
        } else if($search =='all' AND $date == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa =='all') {
            $where = "WHERE users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec'";
        } else if($search =='all' AND $date == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa !='all') {
            $where = "WHERE users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec' AND users.kddesa='$kddesa'";
        } else if ($search !='all'  AND $date == "all" AND $kdprov== 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $date = date("Y-m-d", strtotime($date));
            $where = "WHERE users.name LIKE '%$search%'";
        } else if ($search !='all' AND $date != "all" AND $kdprov== 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $date = date("Y-m-d", strtotime($date));
            $where = "WHERE DATE(daily_activity.date)='$date' AND users.name LIKE '%$search%'";
        }  else if($search !='all' AND $date != "all" AND $kdprov!= 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $date = date("Y-m-d", strtotime($date));
            $where = "WHERE DATE(daily_activity.date)='$date' AND users.kdprov='$kdprov' AND users.name LIKE '%$search%'";
        }  else if($search !='all' AND $date != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $date = date("Y-m-d", strtotime($date));
            $where = "WHERE DATE(daily_activity.date)='$date' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.name LIKE '%$search%'";
        }  else if($search !='all' AND $date != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa=='all') {
            $date = date("Y-m-d", strtotime($date));
            $where = "WHERE DATE(daily_activity.date)='$date' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec' AND users.name LIKE '%$search%'";
        } else if($search !='all' AND $date != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa!='all') {
            $date = date("Y-m-d", strtotime($date));
            $where = "WHERE DATE(daily_activity.date)='$date' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec' AND users.kddesa='$kddesa' AND users.name LIKE '%$search%'";
        } else if($search !='all' AND $date == "all" AND $kdprov!= 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa =='all') {
            $where = "WHERE users.kdprov='$kdprov' AND users.name LIKE '%$search%'";
        } else if($search !='all' AND $date == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec == 'all' AND $kddesa =='all') {
            $where = "WHERE users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.name LIKE '%$search%'";
        } else if($search !='all' AND $date == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa =='all') {
            $where = "WHERE users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec' AND users.name LIKE '%$search%'";
        } else if($search !='all' AND $date == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa !='all') {
            $where = "WHERE users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec' AND users.kddesa='$kddesa' AND users.name LIKE '%$search%'";
        } else {
            $where = '';
        }

        if($id_user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;            
            
            $data  = DB::select( DB::raw("SELECT *, daily_activity.title AS rencana, daily_activity.date AS tgl, daily_activity.id AS id_main FROM daily_activity LEFT JOIN users ON daily_activity.created_by = users.id LEFT JOIN departments ON departments.id = users.department_id LEFT JOIN wilayah_provinsi ON users.kdprov = wilayah_provinsi.kdprov LEFT JOIN wilayah_kabupaten ON users.kdkab=wilayah_kabupaten.kdkab LEFT JOIN wilayah_kecamatan ON users.kdkec = wilayah_kecamatan.kdkec LEFT JOIN wilayah_desa ON users.kddesa = wilayah_desa.kddesa  $where  ORDER BY daily_activity.id DESC LIMIT $total, $limit "));
            $count  = DB::select( DB::raw("SELECT COUNT(daily_activity.id) AS id FROM daily_activity LEFT JOIN users ON daily_activity.created_by = users.id $where "))['0']->id;
            

            $total_page = ceil($count / $limit);

            if($total_page == 0) {
                $total_page = 1;
            }   

            return response()->json(['status' => 'success' ,'data' => $data, 'count' => $count, 'total_page' => $total_page, 'total' => $total]);
            
        } else {

            return redirect('sign-in');
        }
        
    } 

    public function eksportAktivitas(Request $request, $bulan, $tahun)
    {


        $user = Auth::user();

        if($user) {

            $check_durasi  = DB::select( DB::raw("SELECT id, timestampdiff(second, check_in, check_out) AS detik FROM attendances WHERE stay_time IS NULL"));
        
            if (count($check_durasi) > 0) {
                foreach ($check_durasi as $value) {

                    if ($value->detik > 28800) {
                        $durasi = 28800;
                    } else {
                        $durasi = $value->detik;
                    }

                    Attendance::where('id',$value->id)->update(['stay_time' => $durasi]);
                }
            }

            $id_user = Auth::user()->id;
            $nama = Auth::user()->name;
            $id_dep = Auth::user()->department_id;
            $kdprov = Auth::user()->kdprov;
            $kdkab = Auth::user()->kdkab;
            $kdkec = Auth::user()->kdkec;
            $kddesa = Auth::user()->kddesa;
            
            $durasi  = DB::select( DB::raw("SELECT SUM(stay_time) AS detik FROM attendances WHERE user_id='$id_user' AND YEAR(date) = '$tahun' and MONTH(date) = '$bulan'"))['0']->detik;
            $total_kerja  = DB::select( DB::raw("SELECT COUNT(id) AS id FROM attendances WHERE user_id='$id_user' AND YEAR(date) = '$tahun' and MONTH(date) = '$bulan'"))['0']->id;
            $data  = DB::select( DB::raw("SELECT * FROM daily_activity WHERE created_by = '$id_user' and YEAR(date) = '$tahun' and MONTH(date) = '$bulan' ORDER BY id DESC"));
            $leave  = DB::select( DB::raw("SELECT *,leave_types.name AS name, leave_requests.status_id AS stt, leave_requests.days AS durasi FROM leave_requests  Join assign_leaves on assign_leaves.id = leave_requests.assign_leave_id LEFT JOIN leave_types ON assign_leaves.type_id = leave_types.id  WHERE leave_requests.user_id = '$id_user' AND MONTH(leave_from) = '$bulan' AND leave_requests.status_id=1"));
            
            $department  = DB::select( DB::raw("SELECT title FROM departments WHERE id = '$id_dep'"))['0']->title ?? '';
            $nmprov  = DB::select( DB::raw("SELECT nmprov FROM wilayah_provinsi WHERE kdprov = '$kdprov'"))['0']->nmprov ?? '';
            $nmkab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab = '$kdkab'"))['0']->nmkab ?? '';
            $nmkec  = DB::select( DB::raw("SELECT nmkec FROM wilayah_kecamatan WHERE kdkec = '$kdkec'"))['0']->nmkec ?? '';
            $nmdesa  = DB::select( DB::raw("SELECT nmdesa FROM wilayah_desa WHERE kddesa = '$kddesa'"))['0']->nmdesa ?? '';
            
            return view('drp.fasilitator.eksport-aktivitas-harian', compact('data', 'department', 'nama', 'nmprov', 'nmkab', 'id_dep', 'nmkec', 'nmdesa', 'bulan', 'durasi', 'total_kerja', 'leave'));
            
        } else {

            return redirect('sign-in');
        }
        
    }
    public function eksportAktivitasApi($id)
        {
            $user = User::where('id',$id)->first();
           
            if($user) {

                $id_user = $user->id;
                $nama = $user->name;
                $id_dep = $user->department_id;
                $kdprov = $user->kdprov;
                $kdkab = $user->kdkab;
                $kdkec = $user->kdkec;
                $kddesa = $user->kddesa;

                $currentMonth = now()->month;
                $currentYear = now()->year;
                $data  = DB::select( DB::raw("SELECT * FROM daily_activity WHERE created_by = '$id_user' and YEAR('date') = '$currentYear' and MONTH(`date`) = '$currentMonth' ORDER BY id DESC"));
                $department  = DB::select( DB::raw("SELECT title FROM departments WHERE id = '$id_dep'"))['0']->title ?? '';
                $nmprov  = DB::select( DB::raw("SELECT nmprov FROM wilayah_provinsi WHERE kdprov = '$kdprov'"))['0']->nmprov ?? '';
                $nmkab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab = '$kdkab'"))['0']->nmkab ?? '';
                $nmkec  = DB::select( DB::raw("SELECT nmkec FROM wilayah_kecamatan WHERE kdkec = '$kdkec'"))['0']->nmkec ?? '';
                $nmdesa  = DB::select( DB::raw("SELECT nmdesa FROM wilayah_desa WHERE kddesa = '$kddesa'"))['0']->nmdesa ?? '';
                $bulan = $currentMonth;
                return view('drp.fasilitator.eksport-aktivitas-harian', compact('data', 'department', 'nama', 'nmprov', 'nmkab', 'id_dep', 'nmkec', 'nmdesa','bulan'));

            } else {
               
                return $this->responseWithError($exception->getMessage(), [], 500);
            }
            
        }

        public function eksportAktivitasApiV2($id, $bulan, $tahun)
        {
            $user = User::where('id',$id)->first();
           
            if($user) {

                $check_durasi  = DB::select( DB::raw("SELECT id, timestampdiff(second, check_in, check_out) AS detik FROM attendances WHERE stay_time IS NULL"));
        
                if (count($check_durasi) > 0) {
                    foreach ($check_durasi as $value) {

                        if ($value->detik > 28800) {
                            $durasi = 28800;
                        } else {
                            $durasi = $value->detik;
                        }

                        Attendance::where('id',$value->id)->update(['stay_time' => $durasi]);
                    }
                }

                $id_user = $user->id;
                $nama = $user->name;
                $id_dep = $user->department_id;
                $kdprov = $user->kdprov;
                $kdkab = $user->kdkab;  
                $kdkec = $user->kdkec;
                $kddesa = $user->kddesa;

                $durasi  = DB::select( DB::raw("SELECT SUM(stay_time) AS detik FROM attendances WHERE user_id='$id_user' AND YEAR(date) = '$tahun' and MONTH(date) = '$bulan'"))['0']->detik;
                $total_kerja  = DB::select( DB::raw("SELECT COUNT(id) AS id FROM attendances WHERE user_id='$id_user' AND YEAR(date) = '$tahun' and MONTH(date) = '$bulan'"))['0']->id;
                $data  = DB::select( DB::raw("SELECT * FROM daily_activity WHERE created_by = '$id_user' and YEAR(date) = '$tahun' and MONTH(date) = '$bulan' ORDER BY id DESC"));
                $leave  = DB::select( DB::raw("SELECT *,leave_types.name AS name, leave_requests.status_id AS stt, leave_requests.days AS durasi FROM leave_requests  Join assign_leaves on assign_leaves.id = leave_requests.assign_leave_id LEFT JOIN leave_types ON assign_leaves.type_id = leave_types.id  WHERE leave_requests.user_id = '$id_user' AND MONTH(leave_from) = '$bulan' AND leave_requests.status_id=1"));
                $department  = DB::select( DB::raw("SELECT title FROM departments WHERE id = '$id_dep'"))['0']->title ?? '';
                $nmprov  = DB::select( DB::raw("SELECT nmprov FROM wilayah_provinsi WHERE kdprov = '$kdprov'"))['0']->nmprov ?? '';
                $nmkab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab = '$kdkab'"))['0']->nmkab ?? '';
                $nmkec  = DB::select( DB::raw("SELECT nmkec FROM wilayah_kecamatan WHERE kdkec = '$kdkec'"))['0']->nmkec ?? '';
                $nmdesa  = DB::select( DB::raw("SELECT nmdesa FROM wilayah_desa WHERE kddesa = '$kddesa'"))['0']->nmdesa ?? '';
                
                return view('drp.fasilitator.eksport-aktivitas-harian', compact('data', 'department', 'nama', 'nmprov', 'nmkab', 'id_dep', 'nmkec', 'nmdesa','bulan', 'durasi', 'total_kerja', 'leave'));
                
            } else {
               
                return $this->responseWithError($exception->getMessage(), [], 500);
            }
            
        }


    public function editAktivitas($id)
    {
        $user = Auth::user();

        if($user) {

            $data  = DB::select( DB::raw("SELECT * FROM daily_activity WHERE md5(id) = '$id'"));

            return view('drp.fasilitator.edit-aktivitas-harian', compact('data'));
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function updateAktivitas(Request $request)
    {
        $rules = array(
            'title'    =>  'required',
            'description'    =>  'required',
            'location'    =>  'required',
            'latitude'    =>  'required',
            'longitude'    =>  'required',
            'date'    =>  'required',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }



        $profileImage = $request->file('file');
        if (empty($profileImage)) {
            
            $form_data = array(
                'created_by'        =>  Auth::user()->id,
                'title'        =>  $request->title,
                'description'        =>  $request->description,
                'location'        =>  $request->location,
                'latitude'        =>  $request->latitude,
                'longitude'        =>  $request->longitude,
                'date'        =>  date("Y-m-d", strtotime($request->date)),
                'appoinment_start_at'        =>  $request->appoinment_start_at,
                'appoinment_end_at'        =>  $request->appoinment_end_at,
                'appoinment_with'        => 1,
                'company_id'        => 1,
                'status_id'        =>  1,
                'branch_id'        =>  1,
            );

        } else {

            $profileImageSaveAsName = time() . "-aktivitasharian." . 
            $profileImage->getClientOriginalExtension();
            $upload_path = 'aktivitasharian/';
            $profile_image_url = $upload_path . $profileImageSaveAsName;
            $success = $profileImage->move($upload_path, $profileImageSaveAsName);

            $form_data = array(
                'created_by'        =>  Auth::user()->id,
                'file'        =>  $profile_image_url,
                'title'        =>  $request->title,
                'description'        =>  $request->description,
                'location'        =>  $request->location,
                'latitude'        =>  $request->latitude,
                'longitude'        =>  $request->longitude,
                'date'        =>  date("Y-m-d", strtotime($request->date)),
                'appoinment_start_at'        =>  $request->appoinment_start_at,
                'appoinment_end_at'        =>  $request->appoinment_end_at,
                'appoinment_with'        => 1,
                'company_id'        => 1,
                'status_id'        =>  1,
                'branch_id'        =>  1,
            );


        }

        
        Aktivitasharian::whereId($request->hidden_id)->update($form_data);
        return response()->json(['status' => 'success']);
        
    }
    

    public function aktivitasKorkab(Request $request)
    {
        $user = Auth::user();

        if($user) {

            $kdkab = Auth::user()->kdkab;
            $nmkab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab='$kdkab'"))['0']->nmkab;   

            return view('drp.admin.aktivitas-harian-korkab', compact('nmkab'));
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function aktivitasFaskab(Request $request)
    {
        $user = Auth::user();

        if($user) {

            $kdkab = Auth::user()->kdkab;
            $nmkab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab='$kdkab'"))['0']->nmkab;   

            return view('drp.admin.aktivitas-harian-faskab', compact('nmkab'));
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function aktivitasFasdis(Request $request)
    {
        $user = Auth::user();

        if($user) {

            $kdkab = Auth::user()->kdkab;
            $nmkab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab='$kdkab'"))['0']->nmkab;   

            return view('drp.admin.aktivitas-harian-fasdis', compact('nmkab'));
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function aktivitasKader(Request $request)
    {
        $user = Auth::user();

        if($user) {

            $kdkab = Auth::user()->kdkab;
            $nmkab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab='$kdkab'"))['0']->nmkab;   

            return view('drp.admin.aktivitas-harian-kader', compact('nmkab'));
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function getAktivitasKorkab(Request $request, $page, $limit, $date)
    {
        $user = Auth::user();

        if ($date != "all") {
            $date = date("Y-m-d", strtotime($date));
            $where = "AND DATE(daily_activity.date)='$date'";
        } else {
            $where = "";
        }

        if($user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;
            
            
            $kdkab = Auth::user()->kdkab;
            $data  = DB::select( DB::raw("SELECT *, daily_activity.title AS rencana, daily_activity.date AS tgl FROM daily_activity LEFT JOIN users ON daily_activity.created_by = users.id LEFT JOIN departments ON departments.id = users.department_id  WHERE users.kdkab = '$kdkab' AND department_id =5 $where  ORDER BY daily_activity.id DESC LIMIT $total, $limit "));
            $count  = DB::select( DB::raw("SELECT COUNT(daily_activity.id) AS id FROM daily_activity LEFT JOIN users ON daily_activity.created_by = users.id WHERE users.kdkab = '$kdkab' AND department_id =5 $where "))['0']->id;

            $total_page = ceil($count / $limit);

            if($total_page == 0) {
                $total_page = 1;
            }   

            return response()->json(['status' => 'success' ,'data' => $data, 'count' => $count, 'total_page' => $total_page, 'total' => $total]);
            
        } else {

            return redirect('sign-in');
        }
        
    } 

    public function getAktivitasFaskab(Request $request, $page, $limit, $date)
    {
        $user = Auth::user();

        if ($date != "all") {
            $date = date("Y-m-d", strtotime($date));
            $where = "AND DATE(daily_activity.date)='$date'";
        } else {
            $where = "";
        }

        if($user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;
            
            
            $kdkab = Auth::user()->kdkab;
            $data  = DB::select( DB::raw("SELECT *, daily_activity.title AS rencana, daily_activity.date AS tgl FROM daily_activity LEFT JOIN users ON daily_activity.created_by = users.id LEFT JOIN departments ON departments.id = users.department_id  WHERE users.kdkab = '$kdkab' AND department_id =6 $where  ORDER BY daily_activity.id DESC LIMIT $total, $limit "));
            $count  = DB::select( DB::raw("SELECT COUNT(daily_activity.id) AS id FROM daily_activity LEFT JOIN users ON daily_activity.created_by = users.id WHERE users.kdkab = '$kdkab' AND department_id =6 $where "))['0']->id;

            $total_page = ceil($count / $limit);

            if($total_page == 0) {
                $total_page = 1;
            }   

            return response()->json(['status' => 'success' ,'data' => $data, 'count' => $count, 'total_page' => $total_page, 'total' => $total]);
            
        } else {

            return redirect('sign-in');
        }
        
    } 

    public function getAktivitasFasdis(Request $request, $page, $limit, $date)
    {
        $user = Auth::user();

        if ($date != "all") {
            $date = date("Y-m-d", strtotime($date));
            $where = "AND DATE(daily_activity.date)='$date'";
        } else {
            $where = "";
        }

        if($user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;
            
            
            $kdkab = Auth::user()->kdkab;
            $data  = DB::select( DB::raw("SELECT *, daily_activity.title AS rencana, daily_activity.date AS tgl FROM daily_activity LEFT JOIN users ON daily_activity.created_by = users.id LEFT JOIN departments ON departments.id = users.department_id LEFT JOIN wilayah_kecamatan ON users.kdkec = wilayah_kecamatan.kdkec  WHERE users.kdkab = '$kdkab' AND department_id =7 $where  ORDER BY daily_activity.id DESC LIMIT $total, $limit "));
            $count  = DB::select( DB::raw("SELECT COUNT(daily_activity.id) AS id FROM daily_activity LEFT JOIN users ON daily_activity.created_by = users.id WHERE users.kdkab = '$kdkab' AND department_id =7 $where "))['0']->id;

            $total_page = ceil($count / $limit);

            if($total_page == 0) {
                $total_page = 1;
            }   

            return response()->json(['status' => 'success' ,'data' => $data, 'count' => $count, 'total_page' => $total_page, 'total' => $total]);
            
        } else {

            return redirect('sign-in');
        }
        
    } 

    public function getAktivitasKader(Request $request, $page, $limit, $date)
    {
        $user = Auth::user();

        if ($date != "all") {
            $date = date("Y-m-d", strtotime($date));
            $where = "AND DATE(daily_activity.date)='$date'";
        } else {
            $where = "";
        }

        if($user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;
            
            
            $kdkab = Auth::user()->kdkab;
            $kdkec = Auth::user()->kdkec;

            if (Auth::user()->department_id==7) {

                $data  = DB::select( DB::raw("SELECT *, daily_activity.title AS rencana, daily_activity.date AS tgl FROM daily_activity LEFT JOIN users ON daily_activity.created_by = users.id LEFT JOIN departments ON departments.id = users.department_id LEFT JOIN wilayah_kecamatan ON users.kdkec = wilayah_kecamatan.kdkec LEFT JOIN wilayah_desa ON users.kddesa = wilayah_desa.kddesa WHERE users.kdkab = '$kdkab' AND users.kdkec = '$kdkec' AND department_id =8 $where  ORDER BY daily_activity.id DESC LIMIT $total, $limit "));
                $count  = DB::select( DB::raw("SELECT COUNT(daily_activity.id) AS id FROM daily_activity LEFT JOIN users ON daily_activity.created_by = users.id WHERE users.kdkab = '$kdkab' AND users.kdkec = '$kdkec' AND department_id =8 $where "))['0']->id;

            } else {

                $data  = DB::select( DB::raw("SELECT *, daily_activity.title AS rencana, daily_activity.date AS tgl FROM daily_activity LEFT JOIN users ON daily_activity.created_by = users.id LEFT JOIN departments ON departments.id = users.department_id LEFT JOIN wilayah_kecamatan ON users.kdkec = wilayah_kecamatan.kdkec LEFT JOIN wilayah_desa ON users.kddesa = wilayah_desa.kddesa WHERE users.kdkab = '$kdkab'  AND department_id =8 $where  ORDER BY daily_activity.id DESC LIMIT $total, $limit "));
                $count  = DB::select( DB::raw("SELECT COUNT(daily_activity.id) AS id FROM daily_activity LEFT JOIN users ON daily_activity.created_by = users.id WHERE users.kdkab = '$kdkab'  AND department_id =8 $where "))['0']->id;

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

    public function deleteAktivitasHarian(Request $request) 
    {

        $id = $request->id_delete;
        $delete  = DB::select( DB::raw("DELETE FROM  daily_activity WHERE id='$id'"));
        return response()->json(['status' => 'success']);
    }

    public function detailRealisasi($id)
    {
        $realisasi  = DB::select( DB::raw("SELECT * FROM daily_activity LEFT JOIN users ON daily_activity.created_by = users.id WHERE daily_activity.id='$id'"));
        return response()->json(['status' => 'success', 'realisasi' => $realisasi]);
    }
}
