<?php

namespace App\Http\Controllers\Drp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tidakmasukkerja;
use App\Models\Upload;
use Validator;
use DB;
use Hash;
use Signature;
use Illuminate\Support\Facades\Auth;

class TidakmasukController extends Controller
{

    public function tidakMasuk(Request $request)
    {
        $user = Auth::user();

        if($user) {
            $provinsi  = DB::select( DB::raw("SELECT * FROM wilayah_provinsi ORDER BY nmprov ASC"));
            return view('drp.admin.tidak-masuk', compact('provinsi'));
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function tidakMasukSaya(Request $request)
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

            return view('drp.fasilitator.tidak-masuk-saya', compact('provinsi', 'kab', 'kec', 'desa'));
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function tidakMasukTim(Request $request)
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

            return view('drp.fasilitator.tidak-masuk-tim', compact('provinsi', 'kab', 'kec', 'desa'));
            
        } else {

            return redirect('sign-in');
        }
        
    }


    public function tambahTidakMasuk(Request $request)
    {
        $user = Auth::user();
        $department = Auth::user()->department_id;
        if($user) {

            $data  = DB::select( DB::raw("SELECT leave_types.*, assign_leaves.id as assign_leaves_id FROM leave_types
            join assign_leaves on assign_leaves.type_id = leave_types.id
            where assign_leaves.department_id = $department
            ORDER BY name ASC"));

            return view('drp.fasilitator.tambah-tidak-masuk', compact('data'));
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function saveTidakMasuk(Request $request)
    {
        
        $rules = array(
            'assign_leave_id'    =>  'required',
            'leave_from'    =>  'required',
            'leave_to'    =>  'required',
            'reason'    =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        // $explode = explode("-", $request->daterange);
        $leave_from = date("Y-m-d", strtotime($request->leave_from));
        $leave_to = date("Y-m-d", strtotime($request->leave_to));

        if ($leave_from > $leave_to) {
            return response()->json(['status' => 'warning']);
        }

        $date_1 = strtotime($leave_from); 
        $date_2 = strtotime($leave_to); 
        $dis = $date_2 - $date_1;
        $days = $dis / 60 / 60 / 24;
        

        $form_data = array(
            'user_id'        =>  Auth::user()->id,
            'assign_leave_id'        =>  $request->assign_leave_id,
            'apply_date'        =>  date('Y-m-d'),
            'leave_from'        =>  $leave_from,
            'leave_to'        =>  $leave_to,
            'days'        =>  $days + 1,
            'reason'        =>  $request->reason,
            'status_id'        => 2,
            'branch_id'        =>  1,
            'company_id'        =>  1,
        );

        Tidakmasukkerja::create($form_data);

        $id_max_leave  = DB::select( DB::raw("SELECT max(id) AS id FROM leave_requests"))['0']->id;

        $profileImage = $request->file('file');
        $profileImageSaveAsName = time() . "-leave." . 
        $profileImage->getClientOriginalExtension();
        $upload_path = 'allUploads/uploads/employeeDocuments/';
        $profile_image_url = $upload_path . $profileImageSaveAsName;
        $success = $profileImage->move($upload_path, $profileImageSaveAsName);

        $ext = $profileImage->getClientOriginalExtension();

        $form_data = array(
            'user_id'        =>  Auth::user()->id,
            'img_path'        => $profile_image_url,
            'extension'        => ".".$ext."",
            'type'        => $ext,
            'branch_id'        =>  1,
            'company_id'        =>  1,
        );

        Upload::create($form_data);

        $id_max  = DB::select( DB::raw("SELECT max(id) AS id FROM uploads"))['0']->id;

        $form_file = array(
            'attachment_file_id'        =>  $id_max,
        );  

        Tidakmasukkerja::whereId($id_max_leave)->update($form_file); 



        return response()->json(['status' => 'success']);
        
    }

    public function getTidakMasuk(Request $request, $page, $limit, $search, $date, $kdprov, $kdkab, $kdkec, $kddesa)
    {
        $id_user = Auth::user()->id;

        // if ($date != "all") {
        //     $date = date("Y-m-d", strtotime($date));
        //     $where = "WHERE  DATE(apply_date)='$date'";
        // } else {
        //     $where = "";
        // }
        if ($search!='all' AND $date != "all" AND $kdprov== 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $date = date("Y-m-d", strtotime($date));
            $where = "WHERE users.name LIKE '%$search%' AND DATE(apply_date)='$date'";
        } else if ($search!='all' AND $date == "all" AND $kdprov== 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $where = "WHERE users.name LIKE '%$search%'";
        }   else if ($search!='all' AND $date == "all" AND $kdprov== 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $where = "WHERE users.name LIKE '%$search%'";
        }  else if ($search=='all' AND $date != "all" AND $kdprov== 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $date = date("Y-m-d", strtotime($date));
            $where = "WHERE DATE(apply_date)='$date'";
        }  else if($search!='all' AND $date != "all" AND $kdprov!= 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $date = date("Y-m-d", strtotime($date));
            $where = "WHERE users.name LIKE '%$search%' AND DATE(apply_date)='$date' AND users.kdprov='$kdprov'";
        }  else if($search!='all' AND $date != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $date = date("Y-m-d", strtotime($date));
            $where = "WHERE users.name LIKE '%$search%' AND DATE(apply_date)='$date' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab'";
        }  else if($search!='all' AND $date != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa=='all') {
            $date = date("Y-m-d", strtotime($date));
            $where = "WHERE users.name LIKE '%$search%' AND DATE(apply_date)='$date' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec'";
        } else if($search!='all' AND $date != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa!='all') {

            $date = date("Y-m-d", strtotime($date));
            $where = "WHERE users.name LIKE '%$search%' AND DATE(apply_date)='$date' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec' AND users.kddesa='$kddesa'";

        } else if($date == "all" AND $kdprov!= 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa =='all') {
            $where = "WHERE users.kdprov='$kdprov'";
        } else if($date == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec == 'all' AND $kddesa =='all') {
            $where = "WHERE users.kdprov='$kdprov' AND users.kdkab='$kdkab'";
        } else if($date == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa =='all') {
            $where = "WHERE users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec'";
        } else if($date == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa !='all') {
            $where = "WHERE users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec' AND users.kddesa='$kddesa'";
        } else {
            $where = '';
        }


        if($id_user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;            
            
            // $data  = DB::select( DB::raw("SELECT *, users.name AS nama,leave_requests.status_id AS stt, leave_requests.id AS id_main, departments.title AS peran FROM leave_requests LEFT JOIN users ON leave_requests.user_id = users.id LEFT JOIN leave_types ON leave_requests.assign_leave_id = leave_types.id LEFT JOIN uploads ON leave_requests.attachment_file_id = uploads.id LEFT JOIN departments ON users.department_id = departments.id LEFT JOIN wilayah_provinsi ON users.kdprov = wilayah_provinsi.kdprov LEFT JOIN wilayah_kabupaten ON users.kdkab=wilayah_kabupaten.kdkab LEFT JOIN wilayah_kecamatan ON users.kdkec = wilayah_kecamatan.kdkec LEFT JOIN wilayah_desa ON users.kddesa = wilayah_desa.kddesa $where  ORDER BY leave_requests.id DESC LIMIT $total, $limit "));

            $data  = DB::select( DB::raw("SELECT *,leave_types.name AS name, users.name AS nama,leave_requests.status_id AS stt, leave_requests.days AS durasi, departments.title AS peran,leave_requests.id AS id_main  FROM leave_requests  Join assign_leaves on assign_leaves.id = leave_requests.assign_leave_id LEFT JOIN leave_types ON assign_leaves.type_id = leave_types.id  LEFT JOIN users ON leave_requests.user_id = users.id  LEFT JOIN uploads ON leave_requests.attachment_file_id = uploads.id  LEFT JOIN departments ON users.department_id = departments.id LEFT JOIN wilayah_provinsi ON users.kdprov = wilayah_provinsi.kdprov LEFT JOIN wilayah_kabupaten ON users.kdkab=wilayah_kabupaten.kdkab LEFT JOIN wilayah_kecamatan ON users.kdkec = wilayah_kecamatan.kdkec LEFT JOIN wilayah_desa ON users.kddesa = wilayah_desa.kddesa $where ORDER BY leave_requests.id DESC LIMIT $total, $limit "));

            $count  = DB::select( DB::raw("SELECT COUNT(leave_requests.id) AS id FROM leave_requests LEFT JOIN users ON leave_requests.user_id = users.id $where "))['0']->id;
            

            $total_page = ceil($count / $limit);

            if($total_page == 0) {
                $total_page = 1;
            }   

            return response()->json(['status' => 'success' ,'data' => $data, 'count' => $count, 'total_page' => $total_page, 'total' => $total]);
            
        } else {

            return redirect('sign-in');
        }
        
    } 

    public function getTidakMasukSaya(Request $request, $page, $limit, $date)
    {
        $id_user = Auth::user()->id;

        if ($date != "all") {
            $date = date("Y-m-d", strtotime($date));
            $where = "WHERE leave_requests.user_id='$id_user' AND DATE(apply_date)='$date'";
        } else {
            $where = "WHERE leave_requests.user_id='$id_user'";
        }

        if($id_user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;            
            
            // $data  = DB::select( DB::raw("SELECT *, users.name AS nama,leave_requests.status_id AS stt,leave_requests.id AS id_main FROM leave_requests LEFT JOIN users ON leave_requests.user_id = users.id LEFT JOIN leave_types ON leave_requests.assign_leave_id = leave_types.id LEFT JOIN uploads ON leave_requests.attachment_file_id = uploads.id $where  ORDER BY leave_requests.id DESC LIMIT $total, $limit "));
            $data  = DB::select( DB::raw("SELECT *,leave_types.name AS name, users.name AS nama,leave_requests.status_id AS stt, leave_requests.days AS durasi, leave_requests.id AS id_main 
            FROM leave_requests 
            Join assign_leaves on assign_leaves.id = leave_requests.assign_leave_id
            LEFT JOIN leave_types ON assign_leaves.type_id = leave_types.id 
            LEFT JOIN users ON leave_requests.user_id = users.id 
            LEFT JOIN uploads ON leave_requests.attachment_file_id = uploads.id 
            $where  
            ORDER BY leave_requests.id DESC LIMIT $total, $limit "));
            $count  = DB::select( DB::raw("SELECT COUNT(leave_requests.id) AS id FROM leave_requests $where "))['0']->id;
            

            $total_page = ceil($count / $limit);

            if($total_page == 0) {
                $total_page = 1;
            }   

            return response()->json(['status' => 'success' ,'data' => $data, 'count' => $count, 'total_page' => $total_page, 'total' => $total]);
            
        } else {

            return redirect('sign-in');
        }
        
    } 


    public function getTidakMasukTim(Request $request, $page, $limit, $date)
    {
        $user = Auth::user();

        if ($date != "all") {
            $date = date("Y-m-d", strtotime($date));
            $where = "AND DATE(apply_date)='$date'";
        } else {
            $where = "";
        }

        if($user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;
            
            if(Auth::user()->department_id==7){
                $kec = Auth::user()->kdkec;
                $data  = DB::select( DB::raw("SELECT *,leave_types.name AS name, users.name AS nama,leave_requests.status_id AS stt, leave_requests.days AS durasi, leave_requests.id AS id_main FROM leave_requests Join assign_leaves on assign_leaves.id = leave_requests.assign_leave_id LEFT JOIN leave_types ON assign_leaves.type_id = leave_types.id  LEFT JOIN users ON leave_requests.user_id = users.id LEFT JOIN uploads ON leave_requests.attachment_file_id = uploads.id WHERE users.kdkec = '$kec' AND users.department_id =8 $where ORDER BY leave_requests.id DESC LIMIT $total, $limit "));
                $count  = DB::select( DB::raw("SELECT COUNT(leave_requests.id) AS id FROM leave_requests LEFT JOIN users ON leave_requests.user_id = users.id WHERE users.kdkec = '$kec' AND department_id =8 $where  ORDER BY leave_requests.id DESC LIMIT $total, $limit "))['0']->id;
            } else if(Auth::user()->department_id==6){
                $kab = Auth::user()->kdkab;
                $data  = DB::select( DB::raw("SELECT *,leave_types.name AS name, users.name AS nama,leave_requests.status_id AS stt, leave_requests.days AS durasi, leave_requests.id AS id_main FROM leave_requests Join assign_leaves on assign_leaves.id = leave_requests.assign_leave_id LEFT JOIN leave_types ON assign_leaves.type_id = leave_types.id  LEFT JOIN users ON leave_requests.user_id = users.id LEFT JOIN uploads ON leave_requests.attachment_file_id = uploads.id WHERE users.kdkab = '$kab' AND users.department_id =7 $where  ORDER BY leave_requests.id DESC LIMIT $total, $limit  "));
                $count  = DB::select( DB::raw("SELECT COUNT(leave_requests.id) AS id FROM leave_requests LEFT JOIN users ON leave_requests.user_id = users.id WHERE users.kdkab = '$kab' AND department_id =7 $where  ORDER BY leave_requests.id DESC LIMIT $total, $limit "))['0']->id;
            } else if(Auth::user()->department_id==5){
                $kab = Auth::user()->kdkab;
                $data  = DB::select( DB::raw("SELECT *,leave_types.name AS name, users.name AS nama,leave_requests.status_id AS stt, leave_requests.days AS durasi, leave_requests.id AS id_main FROM leave_requests Join assign_leaves on assign_leaves.id = leave_requests.assign_leave_id LEFT JOIN leave_types ON assign_leaves.type_id = leave_types.id  LEFT JOIN users ON leave_requests.user_id = users.id LEFT JOIN uploads ON leave_requests.attachment_file_id = uploads.id WHERE users.kdkab = '$kab' AND users.department_id =6 $where  ORDER BY leave_requests.id DESC LIMIT $total, $limit  "));
                $count  = DB::select( DB::raw("SELECT COUNT(leave_requests.id) AS id FROM leave_requests LEFT JOIN users ON leave_requests.user_id = users.id WHERE users.kdkab = '$kab' AND department_id =6 $where  ORDER BY leave_requests.id DESC LIMIT $total, $limit "))['0']->id;
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

    
    public function getDataTidakMasuk($id)
    {
        $data  = DB::select( DB::raw("SELECT * FROM leave_requests WHERE id='$id'"));
        return response()->json(['data' => $data]);
    }

    public function updateStatusPengajuan(Request $request)
    {
        $id = $request->hidden_id;

        $form = array(
            'status_id'        =>  $request->status,
        );  

        

        Tidakmasukkerja::whereId($id)->update($form); 

        return response()->json(['status' => 'success']);

    }


    public function editTidakMasuk($id)
    {
        $user = Auth::user();
        $department = Auth::user()->department_id;
        if($user) {
            
            $leave  = DB::select( DB::raw("SELECT *  FROM leave_requests WHERE md5(id)='$id'"));

            if(Auth::user()->is_admin==0) {
                $data  = DB::select( DB::raw("SELECT leave_types.*, assign_leaves.id as assign_leaves_id FROM leave_types JOIN assign_leaves ON assign_leaves.type_id = leave_types.id WHERE assign_leaves.department_id = $department ORDER BY name ASC"));
            
            } else {
                $id_user = $leave['0']->user_id;
                $id_department = DB::select( DB::raw("SELECT department_id FROM users WHERE id='$id_user'"))['0']->department_id;
                $data  = DB::select( DB::raw("SELECT leave_types.*, assign_leaves.id as assign_leaves_id FROM leave_types JOIN assign_leaves ON assign_leaves.type_id = leave_types.id WHERE assign_leaves.department_id = '$id_department' ORDER BY name ASC"));
            }

            

            return view('drp.fasilitator.edit-tidak-masuk', compact('data', 'leave'));
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function updateTidakMasuk(Request $request)
    {
        
        $rules = array(
            'assign_leave_id'    =>  'required',
            'leave_from'    =>  'required',
            'leave_to'    =>  'required',
            'reason'    =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        // $explode = explode("-", $request->daterange);
        $leave_from = date("Y-m-d", strtotime($request->leave_from));
        $leave_to = date("Y-m-d", strtotime($request->leave_to));

        if ($leave_from > $leave_to) {
            return response()->json(['status' => 'warning']);
        }

        $date_1 = strtotime($leave_from); 
        $date_2 = strtotime($leave_to); 
        $dis = $date_2 - $date_1;
        $days = $dis / 60 / 60 / 24;
        
        if (Auth::user()->is_admin==1) {
            
            $form_data = array(
                'assign_leave_id'        =>  $request->assign_leave_id,
                'apply_date'        =>  date('Y-m-d'),
                'leave_from'        =>  $leave_from,
                'leave_to'        =>  $leave_to,
                'days'        =>  $days + 1,
                'reason'        =>  $request->reason,
                'status_id'        => $request->status_id,
                'branch_id'        =>  1,
                'company_id'        =>  1,
            );

        } else {

            $form_data = array(
                'user_id'        =>  Auth::user()->id,
                'assign_leave_id'        =>  $request->assign_leave_id,
                'apply_date'        =>  date('Y-m-d'),
                'leave_from'        =>  $leave_from,
                'leave_to'        =>  $leave_to,
                'days'        =>  $days + 1,
                'reason'        =>  $request->reason,
                'status_id'        => $request->status_id,
                'branch_id'        =>  1,
                'company_id'        =>  1,
            );

        }



        

        Tidakmasukkerja::whereId($request->hidden_id)->update($form_data); 

        $id_max_leave  = $request->hidden_id;

        $profileImage = $request->file('file');
        if (!empty($profileImage)) {
            
            $profileImageSaveAsName = time() . "-leave." . 
            $profileImage->getClientOriginalExtension();
            $upload_path = 'allUploads/uploads/employeeDocuments/';
            $profile_image_url = $upload_path . $profileImageSaveAsName;
            $success = $profileImage->move($upload_path, $profileImageSaveAsName);

            $ext = $profileImage->getClientOriginalExtension();

            $form_upload = array(
                'user_id'        =>  Auth::user()->id,
                'img_path'        => $profile_image_url,
                'extension'        => ".".$ext."",
                'type'        => $ext,
                'branch_id'        =>  1,
                'company_id'        =>  1,
            );

            Upload::where('id', $request->attachment_id)->update($form_upload); 
        }
        
       
        return response()->json(['status' => 'success']);
        
    }


    public function tidakMasukKorkab(Request $request)
    {
        $user = Auth::user();
        $kdkab = Auth::user()->kdkab;

        if($user) {
            $nmkab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab='$kdkab'"))['0']->nmkab;
            return view('drp.admin.tidak-masuk-korkab' , compact('nmkab'));
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function tidakMasukFaskab(Request $request)
    {
        $user = Auth::user();
        $kdkab = Auth::user()->kdkab;

        if($user) {
            $nmkab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab='$kdkab'"))['0']->nmkab;
            return view('drp.admin.tidak-masuk-faskab' , compact('nmkab'));
            
        } else {

            return redirect('sign-in');
        }
        
    }
    

    public function tidakMasukFasdis(Request $request)
    {
        $user = Auth::user();
        $kdkab = Auth::user()->kdkab;

        if($user) {
            $nmkab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab='$kdkab'"))['0']->nmkab;
            return view('drp.admin.tidak-masuk-fasdis'  , compact('nmkab'));
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function tidakMasukKader(Request $request)
    {
        $user = Auth::user();
        $kdkab = Auth::user()->kdkab;

        if($user) {
            $nmkab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab='$kdkab'"))['0']->nmkab;
            return view('drp.admin.tidak-masuk-kader' , compact('nmkab'));
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function getTidakMasukKorkab(Request $request, $page, $limit, $date)
    {
        $user = Auth::user();

        if ($date != "all") {
            $date = date("Y-m-d", strtotime($date));
            $where = "AND DATE(apply_date)='$date'";
        } else {
            $where = "";
        }

        if($user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;
            
            
            $kdkab = Auth::user()->kdkab;
            $data  = DB::select( DB::raw("SELECT *,leave_types.name AS name, users.name AS nama,leave_requests.status_id AS stt, leave_requests.days AS durasi, leave_requests.id AS id_main FROM leave_requests Join assign_leaves on assign_leaves.id = leave_requests.assign_leave_id LEFT JOIN leave_types ON assign_leaves.type_id = leave_types.id  LEFT JOIN users ON leave_requests.user_id = users.id LEFT JOIN uploads ON leave_requests.attachment_file_id = uploads.id WHERE users.kdkab = '$kdkab' AND users.department_id = 5 $where ORDER BY leave_requests.id DESC LIMIT $total, $limit "));
            $count  = DB::select( DB::raw("SELECT COUNT(leave_requests.id) AS id FROM leave_requests LEFT JOIN users ON leave_requests.user_id = users.id WHERE users.kdkab = '$kdkab' AND department_id =5 $where  ORDER BY leave_requests.id DESC LIMIT $total, $limit "))['0']->id;
            
            $total_page = ceil($count / $limit);

            if($total_page == 0) {
                $total_page = 1;
            }   

            return response()->json(['status' => 'success' ,'data' => $data, 'count' => $count, 'total_page' => $total_page, 'total' => $total]);
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function getTidakMasukFaskab(Request $request, $page, $limit, $date)
    {
        $user = Auth::user();

        if ($date != "all") {
            $date = date("Y-m-d", strtotime($date));
            $where = "AND DATE(apply_date)='$date'";
        } else {
            $where = "";
        }

        if($user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;
            
            
            $kdkab = Auth::user()->kdkab;
            $data  = DB::select( DB::raw("SELECT *,leave_types.name AS name, users.name AS nama,leave_requests.status_id AS stt, leave_requests.days AS durasi, leave_requests.id AS id_main FROM leave_requests Join assign_leaves on assign_leaves.id = leave_requests.assign_leave_id LEFT JOIN leave_types ON assign_leaves.type_id = leave_types.id  LEFT JOIN users ON leave_requests.user_id = users.id LEFT JOIN uploads ON leave_requests.attachment_file_id = uploads.id WHERE users.kdkab = '$kdkab' AND users.department_id = 6 $where ORDER BY leave_requests.id DESC LIMIT $total, $limit "));
            $count  = DB::select( DB::raw("SELECT COUNT(leave_requests.id) AS id FROM leave_requests LEFT JOIN users ON leave_requests.user_id = users.id WHERE users.kdkab = '$kdkab' AND department_id =6 $where  ORDER BY leave_requests.id DESC LIMIT $total, $limit "))['0']->id;
            
            $total_page = ceil($count / $limit);

            if($total_page == 0) {
                $total_page = 1;
            }   

            return response()->json(['status' => 'success' ,'data' => $data, 'count' => $count, 'total_page' => $total_page, 'total' => $total]);
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function getTidakMasukFasdis(Request $request, $page, $limit, $date)
    {
        $user = Auth::user();

        if ($date != "all") {
            $date = date("Y-m-d", strtotime($date));
            $where = "AND DATE(apply_date)='$date'";
        } else {
            $where = "";
        }

        if($user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;
            
            
            $kdkab = Auth::user()->kdkab;
            $data  = DB::select( DB::raw("SELECT *,leave_types.name AS name, users.name AS nama,leave_requests.status_id AS stt, leave_requests.days AS durasi, leave_requests.id AS id_main FROM leave_requests Join assign_leaves on assign_leaves.id = leave_requests.assign_leave_id LEFT JOIN leave_types ON assign_leaves.type_id = leave_types.id  LEFT JOIN users ON leave_requests.user_id = users.id LEFT JOIN uploads ON leave_requests.attachment_file_id = uploads.id LEFT JOIN wilayah_kecamatan ON users.kdkec = wilayah_kecamatan.kdkec WHERE users.kdkab = '$kdkab' AND users.department_id = 7 $where ORDER BY leave_requests.id DESC LIMIT $total, $limit "));
            $count  = DB::select( DB::raw("SELECT COUNT(leave_requests.id) AS id FROM leave_requests LEFT JOIN users ON leave_requests.user_id = users.id WHERE users.kdkab = '$kdkab' AND department_id =7 $where  ORDER BY leave_requests.id DESC LIMIT $total, $limit "))['0']->id;
            
            $total_page = ceil($count / $limit);

            if($total_page == 0) {
                $total_page = 1;
            }   

            return response()->json(['status' => 'success' ,'data' => $data, 'count' => $count, 'total_page' => $total_page, 'total' => $total]);
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function getTidakMasukKader(Request $request, $page, $limit, $date)
    {
        $user = Auth::user();

        if ($date != "all") {
            $date = date("Y-m-d", strtotime($date));
            $where = "AND DATE(apply_date)='$date'";
        } else {
            $where = "";
        }

        if($user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;
            
            
            $kdkab = Auth::user()->kdkab;
            $kdkec = Auth::user()->kdkec;

            if (Auth::user()->department_id==7) {

                $data  = DB::select( DB::raw("SELECT *,leave_types.name AS name, users.name AS nama,leave_requests.status_id AS stt, leave_requests.days AS durasi, leave_requests.id AS id_main FROM leave_requests Join assign_leaves on assign_leaves.id = leave_requests.assign_leave_id LEFT JOIN leave_types ON assign_leaves.type_id = leave_types.id  LEFT JOIN users ON leave_requests.user_id = users.id LEFT JOIN uploads ON leave_requests.attachment_file_id = uploads.id LEFT JOIN wilayah_kecamatan ON users.kdkec = wilayah_kecamatan.kdkec LEFT JOIN wilayah_desa ON users.kddesa = wilayah_desa.kddesa  WHERE users.kdkab = '$kdkab' AND users.kdkec = '$kdkec' AND users.department_id = 8 $where ORDER BY leave_requests.id DESC LIMIT $total, $limit "));
                $count  = DB::select( DB::raw("SELECT COUNT(leave_requests.id) AS id FROM leave_requests LEFT JOIN users ON leave_requests.user_id = users.id WHERE users.kdkab = '$kdkab' AND users.kdkec = '$kdkec' AND department_id =8 $where  ORDER BY leave_requests.id DESC LIMIT $total, $limit "))['0']->id;

            } else {

                $data  = DB::select( DB::raw("SELECT *,leave_types.name AS name, users.name AS nama,leave_requests.status_id AS stt, leave_requests.days AS durasi, leave_requests.id AS id_main FROM leave_requests Join assign_leaves on assign_leaves.id = leave_requests.assign_leave_id LEFT JOIN leave_types ON assign_leaves.type_id = leave_types.id  LEFT JOIN users ON leave_requests.user_id = users.id LEFT JOIN uploads ON leave_requests.attachment_file_id = uploads.id LEFT JOIN wilayah_kecamatan ON users.kdkec = wilayah_kecamatan.kdkec LEFT JOIN wilayah_desa ON users.kddesa = wilayah_desa.kddesa  WHERE users.kdkab = '$kdkab' AND users.department_id = 8 $where ORDER BY leave_requests.id DESC LIMIT $total, $limit "));
                $count  = DB::select( DB::raw("SELECT COUNT(leave_requests.id) AS id FROM leave_requests LEFT JOIN users ON leave_requests.user_id = users.id WHERE users.kdkab = '$kdkab' AND department_id =8 $where  ORDER BY leave_requests.id DESC LIMIT $total, $limit "))['0']->id;

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

    public function deleteTidakMasuk(Request $request) {

        $id = $request->id_delete;
        $delete  = DB::select( DB::raw("DELETE FROM  leave_requests WHERE id='$id'"));

        return response()->json(['status' => 'success']);
    }
    

    

    
    
        
    
}
