<?php

namespace App\Http\Controllers\Drp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Validator;
use DB;
use Hash;
use Signature;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    
    public function getDataUser($id)
    {
        $user = Auth::user();

        if($user) {

            $data  = DB::select( DB::raw("SELECT *, users.id AS id_main FROM users LEFT JOIN departments ON users.department_id =  departments.id WHERE users.id='$id'"));
            // $kdprov = $data['0']->kdprov;
            // $kdkab = $data['0']->kdkab;
            // $kdkec = $data['0']->kdkec;
            // $kddesa = $data['0']->kddesa;
            // $nama_prov  = DB::select( DB::raw("SELECT nmprov FROM wilayah_provinsi WHERE kdprov='$kdprov'"))['0']->nmprov;
            // $nama_kab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab='$kdkab'"))['0']->nmkab;
            // $nama_kec  = DB::select( DB::raw("SELECT nmkec FROM wilayah_kecamatan WHERE kdkec='$kdkec'"))['0']->nmkec;
            // $nama_desa  = DB::select( DB::raw("SELECT nmdesa FROM wilayah_desa WHERE kddesa='$kddesa'"))['0']->nmdesa;

            return response()->json(['status' => 'success' ,'data' => $data]);
            
        } else {

            return redirect('sign-in');
        }
        
    } 

    public function profile()
    {
        $id = Auth::user()->id;

        $kdprov = Auth::user()->kdprov;
        $kdkab = Auth::user()->kdkab;
        $kdkec = Auth::user()->kdkec;
        $kddesa = Auth::user()->kddesa;

        if (!empty($kdprov)) {
            $data  = DB::select( DB::raw("SELECT * FROM users LEFT JOIN wilayah_provinsi ON users.kdprov = wilayah_provinsi.kdprov LEFT JOIN role ON role.roleid = users.department_id WHERE users.id='$id'"));  
            $nmprov = $data['0']->nmprov;
        } else {
            $data  = DB::select( DB::raw("SELECT * FROM users LEFT JOIN wilayah_provinsi ON users.kdprov = wilayah_provinsi.kdprov LEFT JOIN role ON role.roleid = users.department_id WHERE users.id='$id'"));  
            $nmprov = '';
        }

        if (!empty($kdkab)) {
            $data  = DB::select( DB::raw("SELECT * FROM users LEFT JOIN wilayah_provinsi ON users.kdprov = wilayah_provinsi.kdprov LEFT JOIN wilayah_kabupaten ON users.kdkab = wilayah_kabupaten.kdkab LEFT JOIN role ON role.roleid = users.department_id WHERE users.id='$id'"));   
            $nmkab = $data['0']->nmkab;
        } else {
            $data  = DB::select( DB::raw("SELECT * FROM users LEFT JOIN wilayah_provinsi ON users.kdprov = wilayah_provinsi.kdprov LEFT JOIN wilayah_kabupaten ON users.kdkab = wilayah_kabupaten.kdkab LEFT JOIN role ON role.roleid = users.department_id WHERE users.id='$id'"));   
            $nmkab = '';
        }

        if (!empty($kdkec)) {
            $data  = DB::select( DB::raw("SELECT * FROM users LEFT JOIN wilayah_provinsi ON users.kdprov = wilayah_provinsi.kdprov LEFT JOIN wilayah_kabupaten ON users.kdkab = wilayah_kabupaten.kdkab LEFT JOIN wilayah_kecamatan ON users.kdkec = wilayah_kecamatan.kdkec LEFT JOIN role ON role.roleid = users.department_id WHERE users.id='$id'"));    
            $nmkec = $data['0']->nmkec;
        } else {
            $data  = DB::select( DB::raw("SELECT * FROM users LEFT JOIN wilayah_provinsi ON users.kdprov = wilayah_provinsi.kdprov LEFT JOIN wilayah_kabupaten ON users.kdkab = wilayah_kabupaten.kdkab LEFT JOIN wilayah_kecamatan ON users.kdkec = wilayah_kecamatan.kdkec LEFT JOIN role ON role.roleid = users.department_id WHERE users.id='$id'"));    
            $nmkec = '';
        }

        if (!empty($kddesa)) {
            $data  = DB::select( DB::raw("SELECT * FROM users LEFT JOIN wilayah_provinsi ON users.kdprov = wilayah_provinsi.kdprov LEFT JOIN wilayah_kabupaten ON users.kdkab = wilayah_kabupaten.kdkab LEFT JOIN wilayah_kecamatan ON users.kdkec = wilayah_kecamatan.kdkec LEFT JOIN wilayah_desa ON users.kddesa = wilayah_desa.kddesa LEFT JOIN role ON role.roleid = users.department_id WHERE users.id='$id'")); 
            $nmdesa = $data['0']->nmdesa;
        } else {
            $data  = DB::select( DB::raw("SELECT * FROM users LEFT JOIN wilayah_provinsi ON users.kdprov = wilayah_provinsi.kdprov LEFT JOIN wilayah_kabupaten ON users.kdkab = wilayah_kabupaten.kdkab LEFT JOIN wilayah_kecamatan ON users.kdkec = wilayah_kecamatan.kdkec LEFT JOIN wilayah_desa ON users.kddesa = wilayah_desa.kddesa LEFT JOIN role ON role.roleid = users.department_id WHERE users.id='$id'")); 
            $nmdesa = '';
        }

        return view('drp.fasilitator.profile', compact('data', 'nmprov', 'nmkab', 'nmkec', 'nmdesa'));
    } 

    public function updateStatusUser(Request $request)
    {
        $rules = array(
            'id_user'    =>  'required',
            'name'    =>  'required',
            'nik'    =>  'required',
            'email'    =>  'required',
            'phone'    =>  'required',
            'department_id'    =>  'required',
            // 'kdprov'    =>  'required',
            // 'kdkab'    =>  'required',
            // 'kdkec'    =>  'required',
            // 'kddesa'    =>  'required',
            'gender'    =>  'required',
            'address'    =>  'required',
            'status'    =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        if($request->department_id==1 || $request->department_id==3 || $request->department_id==4 || $request->department_id==5 || $request->department_id==8 || $request->department_id==9) {
            $is_admin = 1;
        } else {
            $is_admin = 0;
        }

        if(empty($request->password)) {
            $form_data = array(
                'name'        =>  $request->name,
                'nik'        =>  $request->nik,
                'email'        =>  $request->email,
                'department_id'        =>  $request->department_id,
                'phone'        =>  $request->phone,
                'kdprov'        =>  $request->kdprov,
                'kdkab'        =>  $request->kdkab,
                'kdkec'        =>  $request->kdkec,
                'kddesa'        =>  $request->kddesa,
                'gender'        =>  $request->gender,
                'address'        =>  $request->address,
                'role_id'        =>   $request->status,
                'is_admin'        =>   $is_admin,
            );
        } else {
            $form_data = array(
                'name'        =>  $request->name,
                'nik'        =>  $request->nik,
                'email'        =>  $request->email,
                'department_id'        =>  $request->department_id,
                'phone'        =>  $request->phone,
                'kdprov'        =>  $request->kdprov,
                'kdkab'        =>  $request->kdkab,
                'kdkec'        =>  $request->kdkec,
                'kddesa'        =>  $request->kddesa,
                'gender'        =>  $request->gender,
                'address'        =>  $request->address,
                'password'        =>  Hash::make($request->password),
                'role_id'        =>   $request->status,
                'is_admin'        =>   $is_admin,
            );
        }       

        User::where('id', $request->id_user)->update($form_data);

        return response()->json(['status' => 'success']);
    } 

    public function evkinFasilitator($id)
    {
        $user = Auth::user();

        if($user) {

            return view('drp.admin.evkin-fasilitator');
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function getEvkinFasilitator(Request $request, $page, $limit, $id)
    {
        $user = Auth::user();

        if($user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;

            $data  = DB::select( DB::raw("SELECT *,evkin.id AS id_main FROM evkin LEFT JOIN users ON users.id = evkin.user_id WHERE periode_id = '$id' ORDER BY name ASC LIMIT $total, $limit "));
            $count  = DB::select( DB::raw("SELECT COUNT(id) AS id FROM evkin WHERE periode_id = '$id'"))['0']->id;

            $total_page = ceil($count / $limit);

            if($total_page == 0) {
                $total_page = 1;
            }   

            return response()->json(['status' => 'success' ,'data' => $data, 'count' => $count, 'total_page' => $total_page, 'total' => $total]);
            
        } else {

            return redirect('sign-in');
        }
        
    }  

    public function nilaiFasilitator($id_periode, $id_user)
    {
        $user = Auth::user();

        if($user) {
            
            $check = DB::select( DB::raw("SELECT nilai FROM evkin WHERE periode_id='$id_periode' AND user_id='$id_user'"))['0']->nilai;

            if($check) {
                $evkin = DB::select( DB::raw("SELECT * FROM evkin WHERE periode_id='$id_periode' AND user_id='$id_user'"));
                return view('drp.admin.detail-nilai-evkin', compact('evkin'));
            } else {
                return view('drp.admin.nilai-fasilitator');
            }          
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function profilFasilitator($id_periode, $id_user)
    {
        $query  = DB::select( DB::raw("SELECT name, kdprov, kdkab, kdkec, kddesa, department_id FROM users WHERE id='$id_user'"));
        $name = $query['0']->name;
        $kdprov = $query['0']->kdprov;
        $kdkab = $query['0']->kdkab;
        $kdkec = $query['0']->kdkec;
        $kddesa = $query['0']->kddesa;
        $id_unit = $query['0']->department_id;

        $unit = DB::select( DB::raw("SELECT title FROM departments WHERE id='$id_unit'"))['0']->title;
        $prov = DB::select( DB::raw("SELECT nmprov FROM wilayah_provinsi WHERE kdprov='$kdprov'"))['0']->nmprov;        
        $kab = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab='$kdkab'"))['0']->nmkab;
        $kec = DB::select( DB::raw("SELECT nmkec FROM wilayah_kecamatan WHERE kdkec='$kdkec'"))['0']->nmkec;
        $desa = DB::select( DB::raw("SELECT nmdesa FROM wilayah_desa WHERE kddesa='$kddesa'"))['0']->nmdesa;
        

        return response()->json(['name' => $name , 'unit' => $unit,'prov' => $prov, 'kab' => $kab, 'kec' => $kec, 'desa' => $desa ]);
    }

    public function updateNilaiEvkin(Request $request)
    {
        
        $rules = array(
            'kehadiran'    =>  'required',
            'akt_harian'    =>  'required',
            'lap_bulanan'    =>  'required',
            'pendampingan_tekad'    =>  'required',
            'supervisi'    =>  'required',
            'rencana_kerja'    =>  'required',
            'output_tupoksi'    =>  'required',
            'pendampingan_masyarakat'    =>  'required',
            'penanganan'    =>  'required',
            'loyalitas'    =>  'required',
            'koordinasi'    =>  'required',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $nilai = $request->kehadiran + $request->akt_harian + $request->lap_bulanan + $request->pendampingan_tekad + $request->supervisi + $request->rencana_kerja + $request->output_tupoksi + $request->pendampingan_masyarakat + $request->penanganan + $request->loyalitas + $request->koordinasi;

        $form_data = array(
            'kehadiran'        =>  $request->kehadiran,
            'akt_harian'        =>  $request->akt_harian,
            'lap_bulanan'        =>  $request->lap_bulanan,
            'pendampingan_tekad'        =>  $request->pendampingan_tekad,
            'supervisi'        =>  $request->supervisi,
            'rencana_kerja'        =>  $request->rencana_kerja,
            'output_tupoksi'        =>  $request->output_tupoksi,
            'pendampingan_masyarakat'        =>  $request->pendampingan_masyarakat,
            'penanganan'        =>  $request->penanganan,
            'loyalitas'        =>  $request->loyalitas,
            'koordinasi'        =>  $request->koordinasi,
            'nilai' => $nilai
        );


        Evkin::where('periode_id', $request->id_periode)->where('user_id', $request->id_user)->update($form_data);

        return response()->json(['status' => 'success']);
    }

    public function deleteUser(Request $request) {

        $id = $request->id_delete;
        $delete  = DB::select( DB::raw("DELETE FROM  users WHERE id='$id'"));

        return response()->json(['status' => 'success']);
    }

    public function syncUser(Request $request) {

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://tekad.kemendesa.go.id/e-lapkin/cronjob/test_sync_user.php',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response = curl_exec($curl);
        // echo $response;
        curl_close($curl);
        // $convert = json_decode($response,true);
        dd($response['0']['data']);

    }
        
    
}
