<?php

namespace App\Http\Controllers\Drp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Validator;
use Redirect;
use DB;
use Hash;
use Signature;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
// use App\Models\Userbackup;

class RegisterdrpController extends Controller
{
    
    public function index(Request $request)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://tekad.kemendesa.go.id/monev/api/mswilprov?email=guest%40alfanumerik.co.id&token=tekad-guest-2023',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        $provinsi = json_decode($response,true);
        curl_close($curl);
        $peran  = DB::select( DB::raw("SELECT * FROM departments ORDER BY id DESC"));
        

        return view('drp.register-drp', compact('provinsi', 'peran'));        
    }

    public function getListKab()
    {
        $kabupaten  = DB::select( DB::raw("SELECT * FROM wilayah_kabupaten ORDER BY nmkab ASC"));
        return response()->json(['kabupaten' => $kabupaten]);  
    }

    public function getKab($id)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://tekad.kemendesa.go.id/monev/api/mswilkab?email=guest@alfanumerik.co.id&token=tekad-guest-2023&kdprov='.$id.'',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        $kabupaten = json_decode($response,true);
        curl_close($curl);

        return response()->json(['kabupaten' => $kabupaten]);       
    }

    public function getKec($id)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://tekad.kemendesa.go.id/monev/api/mswilkec?email=guest@alfanumerik.co.id&token=tekad-guest-2023&kdkab='.$id.'',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        $kecamatan = json_decode($response,true);
        curl_close($curl);

        return response()->json(['kecamatan' => $kecamatan]);       
    }

    public function getDesa($id)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://tekad.kemendesa.go.id/monev/api/mswildesa?email=guest@alfanumerik.co.id&token=tekad-guest-2023&kdkec='.$id.'',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        $desa = json_decode($response,true);
        curl_close($curl);

        return response()->json(['desa' => $desa]);       
    }

    // public function getKab($id)
    // {
    //     $kabupaten  = DB::select( DB::raw("SELECT * FROM wilayah_kabupaten WHERE kdprov='$id' ORDER BY nmkab ASC"));
    //     return response()->json(['kabupaten' => $kabupaten]);
    // }

    // public function getKec($id)
    // {
    //     $kecamatan  = DB::select( DB::raw("SELECT * FROM wilayah_kecamatan WHERE kdkab='$id' ORDER BY nmkec ASC"));
    //     return response()->json(['kecamatan' => $kecamatan]);
    // }

    // public function getDesa($id)
    // {
    //     $desa  = DB::select( DB::raw("SELECT * FROM wilayah_desa WHERE kdkec='$id' ORDER BY nmdesa ASC"));
    //     return response()->json(['desa' => $desa]);
    // }

    public function addDataRegister(Request $request) 
    {

        $form_curl = array(
            'name'        =>  $request->fullname,
            'nik'        =>  $request->nik,
            'email'        =>  $request->email_register,
            'department_id'        =>  $request->roleid,
            'phone'        =>  $request->telpno,
            'kdprov'        =>  $request->kdprov,
            'kdkab'        =>  $request->kdkab,
            'kdkec'        =>  $request->kdkec,
            'kddesa'        =>  $request->kddesa,
            'birth_date'        =>  $request->tgl_lahir,
            'gender'        =>  $request->jenis_kelamin,
            'address'        =>  $request->alamat,
            'password'        =>  $request->password,
        );

        $postdata = json_encode($form_curl);

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://tekad.kemendesa.go.id/e-lapkin/save-register',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $postdata,
        CURLOPT_HTTPHEADER => array(
            'token: aW50ZWdyYXNpbW9uZXZsYXBraW4yMDI0a2VtZW5kZXNh',
            'Content-Type: application/json',
        ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
    }

    public function saveRegister(Request $request)
    {
        
        if(isset(getallheaders()["token"])) {

            $token = getallheaders()["token"];

            if($token !='aW50ZWdyYXNpbW9uZXZsYXBraW4yMDI0a2VtZW5kZXNh') {

                return response()->json(['status' => 'unauthorized', 'message' => 'Token does not match']);  

            } else {
                
                $rules = array(
                    'id_user_monev'    =>  'required',
                    'name'    =>  'required',
                    'nik'    =>  'required',
                    'email'    =>  'required',
                    'department_id'    =>  'required',
                    'phone'    =>  'required',
                    'birth_date'    =>  'required',
                    'gender'    =>  'required',
                    'password'    =>  'required',
                );

                $error = Validator::make($request->all(), $rules);

                if($error->fails())
                {
                    return response()->json(['errors' => $error->errors()->all()]);
                }

                $check_id_monev  = DB::select( DB::raw("SELECT nik FROM users WHERE id_user_monev='$request->id_user_monev'"));
                $check_nik  = DB::select( DB::raw("SELECT nik FROM users WHERE nik='$request->nik'"));
                $check_email  = DB::select( DB::raw("SELECT email FROM users WHERE email='$request->email'"));
                $check_phone  = DB::select( DB::raw("SELECT phone FROM users WHERE phone='$request->phone'"));

                if(!empty($check_id_monev)) {
                    return response()->json(['status' => 'warning', 'message' => 'ID Monev already exist']);  
                }
                if(!empty($check_nik)) {
                    return response()->json(['status' => 'warning', 'message' => 'NIK already exist']);  
                }
                if(!empty($check_email)) {
                    return response()->json(['status' => 'warning', 'message' => 'Email already exist']);  
                }
                if(!empty($check_phone)) {
                    return response()->json(['status' => 'warning', 'message' => 'Phone already exist']);  
                }

                $profileImage = $request->file('backend_image');

                if(empty($profileImage)) {

                    $profile_image_url= "static/blank_small.png";

                } else {

                    $profileImageSaveAsName = time() . "-register." . 
                    $profileImage->getClientOriginalExtension();
                    $upload_path = 'image/register/';
                    $profile_image_url = $upload_path . $profileImageSaveAsName;
                    $success = $profileImage->move($upload_path, $profileImageSaveAsName);
                }

                if ($request->department_id==5 || $request->department_id==6 || $request->department_id==7 || $request->department_id==8 || $request->department_id==33 || $request->department_id==27 || $request->department_id==31) {
                    $isadmin = "0";
                    $kdprov = $request->kdprov;
                } else {
                    $isadmin = "1";
                    $kdprov = "00";
                }

                if ($request->kdprov==00) {
                    $timezone = 'Asia/Jakarta';
                } else if ($request->kdprov==53) {
                    $timezone = 'Asia/Makassar';
                } else {
                    $timezone = 'Asia/Jayapura';
                }

                if ($request->aktif==1) {
                    $status = 1;
                } else {
                    $status = 0;
                }
                

                $form_data = array(
                    'id_user_monev'        =>  $request->id_user_monev,
                    'name'        =>  $request->name,
                    'nik'        =>  $request->nik,
                    'email'        =>  $request->email,
                    'department_id'        =>  $request->department_id,
                    'phone'        =>  $request->phone,
                    'kdprov'        =>  $kdprov,
                    'kdkab'        =>  $request->kdkab,
                    'kdkec'        =>  $request->kdkec,
                    'kddesa'        =>  $request->kddesa,
                    'is_admin'        =>  $isadmin,
                    'birth_date'        =>  date('Y-m-d', strtotime($request->birth_date)) ,
                    'gender'        =>  $request->gender,
                    'address'        =>  $request->address,
                    'password'        =>  Hash::make($request->password),
                    'image'        =>  $profile_image_url,
                    'time_zone'        =>  $timezone,
                    'status_id'        =>  $status,
                    'company_id'        =>  1,
                    'shift_id'        =>  1,
                    'role_id'        =>  0,
                );
                
                User::create($form_data);
                $id_max  = DB::select( DB::raw("SELECT max(id) AS id FROM users"))['0']->id;
                return response()->json(['status' => 'success', 'message' => 'Data user has been added']);
            }
            
        } else {
            return response()->json(['status' => 'unauthorized', 'message' => 'Token cannot empty']);  
        }


    }

    public function verifikasiEmail(Request $request, $id) {

        
        if(isset(getallheaders()["token"])) {

            $token = getallheaders()["token"];

            if($token !='aW50ZWdyYXNpbW9uZXZsYXBraW4yMDI0a2VtZW5kZXNh') {

                return response()->json(['status' => 'unauthorized', 'message' => 'Token does not match']);  

            } else {

                $check  = DB::select( DB::raw("SELECT id FROM users WHERE id_user_monev='$id'"));

                if(empty($check)) {
                    return response()->json(['status' => 'not_found', 'message' => 'User not found']);  
                }

                $form_data = array(
                    'status_id'        =>  1,
                    'role_id'        =>  4,
                );
                
                User::where('id_user_monev', $id)->update($form_data);
                
                return response()->json(['status' => 'success', 'message' => 'Data user has been verified']);  

                // $curl = curl_init();
                // curl_setopt_array($curl, array(
                //         CURLOPT_URL => 'https://tekad.kemendesa.go.id/e-lapkin/cronjob/sync_user.php',
                //         CURLOPT_RETURNTRANSFER => true,
                //         CURLOPT_ENCODING => '',
                //         CURLOPT_MAXREDIRS => 10,
                //         CURLOPT_TIMEOUT => 0,
                //         CURLOPT_FOLLOWLOCATION => true,
                //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                //         CURLOPT_CUSTOMREQUEST => 'GET',
                // ));

                // $response = curl_exec($curl);

                // curl_close($curl);
                // echo $response;
                
            }
            
        } else {
            return response()->json(['status' => 'unauthorized', 'message' => 'Token cannot empty']);  
        }
    }

    public function updateRegister(Request $request, $id)
    {
        
        if(isset(getallheaders()["token"])) {

            $token = getallheaders()["token"];

            if($token !='aW50ZWdyYXNpbW9uZXZsYXBraW4yMDI0a2VtZW5kZXNh') {

                return response()->json(['status' => 'unauthorized', 'message' => 'Token does not match']);  

            } else {
                
                $check  = DB::select( DB::raw("SELECT * FROM users WHERE id_user_monev='$id'"));
                
                if(empty($check)) {
                    return response()->json(['status' => 'not_found', 'message' => 'User not found']);  
                }

                if ($request->aktif==1) {
                    $status = "1";
                } else  if ($request->aktif==null) {
                    $status = "1";
                } else {
                    $status = "0";
                }

                if ($request->department_id==5 || $request->department_id==6 || $request->department_id==7 || $request->department_id==8 || $request->department_id==33 || $request->department_id==27 || $request->department_id==31) {
                    $isadmin = "0";
                    $kdprov = $request->kdprov;
                } else {
                    $isadmin = "1";
                    $kdprov = "00";
                }

                if ($request->kdprov==00) {
                    $timezone = 'Asia/Jakarta';
                } else if ($request->kdprov==53) {
                    $timezone = 'Asia/Makassar';
                } else {
                    $timezone = 'Asia/Jayapura';
                }

                

                    if(empty($request->password)) {


                        $form_data = array(
                            // 'id_user_monev'        =>  $request->id_user_monev,
                            'name'        =>  $request->name,
                            'nik'        =>  $request->nik,
                            'email'        =>  $request->email,
                            'department_id'        =>  $request->department_id,
                            'phone'        =>  $request->phone,
                            'kdprov'        =>  $kdprov,
                            'kdkab'        =>  $request->kdkab,
                            'kdkec'        =>  $request->kdkec,
                            'kddesa'        =>  $request->kddesa,
                            'is_admin'        =>  $isadmin,
                            'birth_date'        =>  date('Y-m-d', strtotime($request->birth_date)) ,
                            'gender'        =>  $request->gender,
                            'address'        =>  $request->address,
                            'status_id'        =>  $status,
                            'aktif'        =>  $status,
                            'time_zone'        =>  $timezone,
                        );

                    } else {

                        
                            $form_data = array(
                                // 'id_user_monev'        =>  $request->id_user_monev,
                                'name'        =>  $request->name,
                                'nik'        =>  $request->nik,
                                'email'        =>  $request->email,
                                'department_id'        =>  $request->department_id,
                                'phone'        =>  $request->phone,
                                'kdprov'        =>  $kdprov,
                                'kdkab'        =>  $request->kdkab,
                                'kdkec'        =>  $request->kdkec,
                                'kddesa'        =>  $request->kddesa,
                                'is_admin'        =>  $isadmin,
                                'birth_date'        =>  date('Y-m-d', strtotime($request->birth_date)) ,
                                'gender'        =>  $request->gender,
                                'address'        =>  $request->address,
                                'password'        =>  Hash::make($request->password),
                                'status_id'        =>  $status,
                                'time_zone'        =>  $timezone,
                            );

                    }
                

                User::where('id_user_monev', $id)->update($form_data);
                return response()->json(['status' => 'success', 'message' => 'Data user has been updated']); 
            }
            
        } else {
            return response()->json(['status' => 'unauthorized', 'message' => 'Token cannot empty']);  
        }

    }

    public function updateRegisterBackup(Request $request, $id)
    {
        
        if(isset(getallheaders()["token"])) {

            $token = getallheaders()["token"];

            if($token !='aW50ZWdyYXNpbW9uZXZsYXBraW4yMDI0a2VtZW5kZXNh') {

                return response()->json(['status' => 'unauthorized', 'message' => 'Token does not match']);  

            } else {
                
                $check  = DB::select( DB::raw("SELECT * FROM users_backup WHERE id_user_monev='$id'"));
                
                if(empty($check)) {
                    return response()->json(['status' => 'not_found', 'message' => 'User not found']);  
                }

                if ($request->aktif==1) {
                    $status = 1;
                } else {
                    $status = 0;
                }

                if ($request->department_id==5 || $request->department_id==6 || $request->department_id==7 || $request->department_id==8 || $request->department_id==33 || $request->department_id==27) {
                    $isadmin = "0";
                    $kdprov = $request->kdprov;
                } else {
                    $isadmin = "1";
                    $kdprov = "00";
                }

                if ($request->kdprov==00) {
                    $timezone = 'Asia/Jakarta';
                } else if ($request->kdprov==53) {
                    $timezone = 'Asia/Makassar';
                } else {
                    $timezone = 'Asia/Jayapura';
                }

               

                    if(empty($request->password)) {

                        $form_data = array(
                            // 'id_user_monev'        =>  $request->id_user_monev,
                            'name'        =>  $request->name,
                            'nik'        =>  $request->nik,
                            'email'        =>  $request->email,
                            'department_id'        =>  $request->department_id,
                            'phone'        =>  $request->phone,
                            'kdprov'        =>  $kdprov,
                            'kdkab'        =>  $request->kdkab,
                            'kdkec'        =>  $request->kdkec,
                            'kddesa'        =>  $request->kddesa,
                            'is_admin'        =>  $isadmin,
                            'birth_date'        =>  date('Y-m-d', strtotime($request->birth_date)) ,
                            'gender'        =>  $request->gender,
                            'address'        =>  $request->address,
                            'status_id'        =>  $status,
                            'time_zone'        =>  $timezone,
                        );

                    } else {

                         


                         if ($request->aktif==null ) {

                            $form_data = array(
                                'password'        =>  Hash::make($request->password),
                                'status_id'        =>  $status,

                            );

                            echo "1";

                        } else {

                            $form_data = array(
                                // 'id_user_monev'        =>  $request->id_user_monev,
                                'name'        =>  $request->name,
                                'nik'        =>  $request->nik,
                                'email'        =>  $request->email,
                                'department_id'        =>  $request->department_id,
                                'phone'        =>  $request->phone,
                                'kdprov'        =>  $kdprov,
                                'kdkab'        =>  $request->kdkab,
                                'kdkec'        =>  $request->kdkec,
                                'kddesa'        =>  $request->kddesa,
                                'is_admin'        =>  $isadmin,
                                'birth_date'        =>  date('Y-m-d', strtotime($request->birth_date)) ,
                                'gender'        =>  $request->gender,
                                'address'        =>  $request->address,
                                'password'        =>  Hash::make($request->password),
                                'status_id'        =>  $status,
                                'time_zone'        =>  $timezone,
                            );

                            echo "2";
                        }

                    
                    }

                // Userbackup::where('id_user_monev', $id)->update($form_data);
                // return response()->json(['status' => 'success', 'message' => 'Data user has been updated']); 

                // $curl = curl_init();
                // curl_setopt_array($curl, array(
                //         CURLOPT_URL => 'https://tekad.kemendesa.go.id/e-lapkin/cronjob/sync_user.php',
                //         CURLOPT_RETURNTRANSFER => true,
                //         CURLOPT_ENCODING => '',
                //         CURLOPT_MAXREDIRS => 10,
                //         CURLOPT_TIMEOUT => 0,
                //         CURLOPT_FOLLOWLOCATION => true,
                //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                //         CURLOPT_CUSTOMREQUEST => 'GET',
                // ));

                // $response = curl_exec($curl);

                // curl_close($curl);
                // echo $response; 
            }
            
        } else {
            return response()->json(['status' => 'unauthorized', 'message' => 'Token cannot empty']);  
        }

    }

    public function successRegister(Request $request)
    {
        
        return view('drp.success-register');          
    }

    public function deleteRegister(Request $request, $id) {

        if(isset(getallheaders()["token"])) {

            $token = getallheaders()["token"];

            if($token !='aW50ZWdyYXNpbW9uZXZsYXBraW4yMDI0a2VtZW5kZXNh') {

                return response()->json(['status' => 'unauthorized', 'message' => 'Token does not match']);  

            } else {

                $check  = DB::select( DB::raw("SELECT * FROM users WHERE id_user_monev='$id'"));
                $id_user = $check['0']->id;


                if(empty($check)) {
                    return response()->json(['status' => 'not_found', 'message' => 'User not found']);  
                }

                $check_absen  = DB::select( DB::raw("SELECT count(id) AS id FROM attendances WHERE user_id='$id_user'"))['0']->id;
                
                if ($check_absen != 0) {
                    return response()->json(['status' => 'warning', 'message' => 'User has attendances data']);  
                }

                $check_akt_harian  = DB::select( DB::raw("SELECT count(id) AS id FROM daily_activity WHERE created_by='$id_user'"))['0']->id;
                
                if ($check_akt_harian != 0) {
                    return response()->json(['status' => 'warning', 'message' => 'User has daily activity data']);  
                }

                $check_lap_bul  = DB::select( DB::raw("SELECT count(id) AS id FROM monthly_report WHERE user_id='$id_user'"))['0']->id;
                
                if ($check_lap_bul != 0) {
                    return response()->json(['status' => 'warning', 'message' => 'User has monthly report data']);  
                }

                $check_tdk_masuk  = DB::select( DB::raw("SELECT count(id) AS id FROM leave_requests WHERE user_id='$id_user'"))['0']->id;
                
                if ($check_tdk_masuk != 0) {
                    return response()->json(['status' => 'warning', 'message' => 'User has leave request data']);  
                }

                $delete  = DB::select( DB::raw("DELETE FROM users WHERE id_user_monev='$id'"));

                if(isset($delete)) 
                {
                    return response()->json(['status' => 'success', 'message' => 'Data user has been deleted']);  
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Failed to delete user']);
                }
            }

        } else {

            return response()->json(['status' => 'unauthorized', 'message' => 'Token cannot empty']);  

        }

        
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('sign-in');
    }

}
