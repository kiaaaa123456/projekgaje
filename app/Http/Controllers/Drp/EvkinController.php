<?php

namespace App\Http\Controllers\Drp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Evkin;
use App\Models\Periodeevkin;
use Validator;
use DB;
use Hash;
use Signature;
use Illuminate\Support\Facades\Auth;

class EvkinController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();

        if($user) {

            $tahun  = DB::select( DB::raw("SELECT DISTINCT(tahun) FROM periode_evkin"));
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

            return view('drp.fasilitator.periode-evkin', compact('provinsi', 'kab', 'kec', 'desa', 'tahun'));
            
        } else {

            return redirect('sign-in');
        }
        
    }


    public function evkinKorkab(Request $request)
    {
        $user = Auth::user();

        $tahun  = DB::select( DB::raw("SELECT DISTINCT(tahun) FROM periode_evkin"));

        if($user) {

            $tahun  = DB::select( DB::raw("SELECT DISTINCT(tahun) FROM periode_evkin"));
            $kdprov = Auth::user()->kdprov;
            $kdkab = Auth::user()->kdkab;

            $nmprov  = DB::select( DB::raw("SELECT nmprov FROM wilayah_provinsi WHERE kdprov='$kdprov'"))['0']->nmprov;
            $nmkab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab='$kdkab'"))['0']->nmkab;
            
            return view('drp.admin.periode-evkin-korkab', compact('nmprov', 'nmkab', 'tahun'));
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function evkinFaskab(Request $request)
    {
        $user = Auth::user();

        $tahun  = DB::select( DB::raw("SELECT DISTINCT(tahun) FROM periode_evkin"));

        if($user) {

            $tahun  = DB::select( DB::raw("SELECT DISTINCT(tahun) FROM periode_evkin"));
            $kdprov = Auth::user()->kdprov;
            $kdkab = Auth::user()->kdkab;


            $nmprov  = DB::select( DB::raw("SELECT nmprov FROM wilayah_provinsi WHERE kdprov='$kdprov'"))['0']->nmprov;
            $nmkab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab='$kdkab'"))['0']->nmkab;
            
            return view('drp.admin.periode-evkin-faskab', compact('nmprov', 'nmkab', 'tahun'));
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function evkinFasdis(Request $request)
    {
        $user = Auth::user();

        $tahun  = DB::select( DB::raw("SELECT DISTINCT(tahun) FROM periode_evkin"));

        if($user) {

            $tahun  = DB::select( DB::raw("SELECT DISTINCT(tahun) FROM periode_evkin"));
            $kdprov = Auth::user()->kdprov;
            $kdkab = Auth::user()->kdkab;


            $nmprov  = DB::select( DB::raw("SELECT nmprov FROM wilayah_provinsi WHERE kdprov='$kdprov'"))['0']->nmprov;
            $nmkab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab='$kdkab'"))['0']->nmkab;
            
            return view('drp.admin.periode-evkin-fasdis', compact('nmprov', 'nmkab', 'tahun'));
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function evkinKader(Request $request)
    {
        $user = Auth::user();

        $tahun  = DB::select( DB::raw("SELECT DISTINCT(tahun) FROM periode_evkin"));

        if($user) {

            $tahun  = DB::select( DB::raw("SELECT DISTINCT(tahun) FROM periode_evkin"));
            $kdprov = Auth::user()->kdprov;
            $kdkab = Auth::user()->kdkab;


            $nmprov  = DB::select( DB::raw("SELECT nmprov FROM wilayah_provinsi WHERE kdprov='$kdprov'"))['0']->nmprov;
            $nmkab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab='$kdkab'"))['0']->nmkab;
            
            return view('drp.admin.periode-evkin-kader', compact('nmprov', 'nmkab', 'tahun'));
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function periodeEvkin(Request $request)
    {
        $user = Auth::user();

        if($user) {

            $provinsi  = DB::select( DB::raw("SELECT * FROM wilayah_provinsi ORDER BY nmprov ASC"));

            return view('drp.admin.periode-evkin', compact('provinsi'));
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function getData(Request $request, $page, $limit, $month, $year)
    {
        $user = Auth::user();
        $id_user = Auth::user()->id;

        if ($month != "all" AND $year =='all') {
            $where = "AND bulan='$month'";
        } else if ($month == "all" AND $year !='all') {
            $where = "AND tahun='$year'";
        } else if ($month != "all" AND $year !='all') {
            $where = "AND bulan='$month' AND tahun='$year'";
        }  else {
            $where = "";
        }

        if($user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;

            $data  = DB::select( DB::raw("SELECT *, periode_evkin.id AS id FROM periode_evkin LEFT JOIN users ON users.id = periode_evkin.user_id WHERE user_id = '$id_user' $where  ORDER BY periode_evkin.id DESC LIMIT $total, $limit "));
            $count  = DB::select( DB::raw("SELECT COUNT(id) AS id FROM periode_evkin WHERE user_id = '$id_user' $where"))['0']->id;

            $total_page = ceil($count / $limit);

            if($total_page == 0) {
                $total_page = 1;
            }   

            return response()->json(['status' => 'success' ,'data' => $data, 'count' => $count, 'total_page' => $total_page, 'total' => $total]);
            
        } else {

            return redirect('sign-in');
        }
        
    } 

    public function getEvkinFaskab(Request $request, $page, $limit, $month, $year)
    {
        $user = Auth::user();
        $id_user = Auth::user()->id;
        $kdkab = Auth::user()->kdkab;

        if ($month != "all" AND $year =='all') {
            $where = "AND bulan='$month'";
        } else if ($month == "all" AND $year !='all') {
            $where = "AND tahun='$year'";
        } else if ($month != "all" AND $year !='all') {
            $where = "AND bulan='$month' AND tahun='$year'";
        }  else {
            $where = "";
        }

        if($user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;

            $data  = DB::select( DB::raw("SELECT *, periode_evkin.id AS id FROM periode_evkin LEFT JOIN users ON users.id = periode_evkin.user_id WHERE peran='faskab'  AND periode_evkin.kdkab='$kdkab'  $where   ORDER BY periode_evkin.id DESC LIMIT $total, $limit "));
            $count  = DB::select( DB::raw("SELECT COUNT(id) AS id FROM periode_evkin WHERE peran='faskab'  AND kdkab='$kdkab'  $where"))['0']->id;

            $total_page = ceil($count / $limit);

            if($total_page == 0) {
                $total_page = 1;
            }   

            return response()->json(['status' => 'success' ,'data' => $data, 'count' => $count, 'total_page' => $total_page, 'total' => $total]);
            
        } else {

            return redirect('sign-in');
        }
        
    } 


    public function getEvkinFasdis(Request $request, $page, $limit, $month, $year)
    {
        $user = Auth::user();
        $id_user = Auth::user()->id;
        $kdkab = Auth::user()->kdkab;

        if ($month != "all" AND $year =='all') {
            $where = "AND bulan='$month'";
        } else if ($month == "all" AND $year !='all') {
            $where = "AND tahun='$year'";
        } else if ($month != "all" AND $year !='all') {
            $where = "AND bulan='$month' AND tahun='$year'";
        }  else {
            $where = "";
        }

        if($user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;

            $data  = DB::select( DB::raw("SELECT *, periode_evkin.id AS id FROM periode_evkin LEFT JOIN users ON users.id = periode_evkin.user_id WHERE peran='fasdis'  AND periode_evkin.kdkab='$kdkab'  $where   ORDER BY periode_evkin.id DESC LIMIT $total, $limit "));
            $count  = DB::select( DB::raw("SELECT COUNT(id) AS id FROM periode_evkin WHERE peran='fasdis'  AND kdkab='$kdkab'  $where"))['0']->id;

            $total_page = ceil($count / $limit);

            if($total_page == 0) {
                $total_page = 1;
            }   

            return response()->json(['status' => 'success' ,'data' => $data, 'count' => $count, 'total_page' => $total_page, 'total' => $total]);
            
        } else {

            return redirect('sign-in');
        }
        
    } 

    public function getEvkinKader(Request $request, $page, $limit, $month, $year)
    {
        $user = Auth::user();
        $id_user = Auth::user()->id;
        $kdkab = Auth::user()->kdkab;

        if ($month != "all" AND $year =='all') {
            $where = "AND bulan='$month'";
        } else if ($month == "all" AND $year !='all') {
            $where = "AND tahun='$year'";
        } else if ($month != "all" AND $year !='all') {
            $where = "AND bulan='$month' AND tahun='$year'";
        }  else {
            $where = "";
        }

        if($user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;

            $data  = DB::select( DB::raw("SELECT *, periode_evkin.id AS id FROM periode_evkin LEFT JOIN users ON users.id = periode_evkin.user_id WHERE peran='kader'  AND periode_evkin.kdkab='$kdkab'  $where   ORDER BY periode_evkin.id DESC LIMIT $total, $limit "));
            $count  = DB::select( DB::raw("SELECT COUNT(id) AS id FROM periode_evkin WHERE peran='kader'  AND kdkab='$kdkab'  $where"))['0']->id;

            $total_page = ceil($count / $limit);

            if($total_page == 0) {
                $total_page = 1;
            }   

            return response()->json(['status' => 'success' ,'data' => $data, 'count' => $count, 'total_page' => $total_page, 'total' => $total]);
            
        } else {

            return redirect('sign-in');
        }
        
    } 

    public function getPeriodeEvkin(Request $request, $page, $limit, $month, $year, $kdprov, $kdkab, $kdkec)
    {
        $user = Auth::user();
        $id_user = Auth::user()->id;

        if ($month != "all" AND $year =='all' AND $kdprov== 'all' AND $kdkab == 'all' AND $kdkec == 'all') {
            $where = "WHERE bulan='$month'";
        } else if ($month == "all" AND $year !='all' AND $kdprov== 'all' AND $kdkab == 'all' AND $kdkec == 'all') {
            $where = "WHERE bulan='$year'";
        } else if ($month != "all" AND $year !='all' AND $kdprov== 'all' AND $kdkab == 'all' AND $kdkec == 'all') {
            $where = "WHERE bulan='$month' AND tahun='$year'";

        } else if ($month != "all" AND $kdprov== 'all' AND $kdkab == 'all' AND $kdkec == 'all') {
            $where = "WHERE bulan='$month'";
        }  else if($month != "all" AND $kdprov!= 'all' AND $kdkab == 'all' AND $kdkec == 'all') {
            $where = "WHERE bulan='$month' AND periode_evkin.kdprov='$kdprov'";
        }  else if($month != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec == 'all') {
            $where = "WHERE bulan='$month' AND periode_evkin.kdprov='$kdprov' AND periode_evkin.kdkab='$kdkab'";
        }  else if($month != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all') {
            $where = "WHERE bulan='$month' AND periode_evkin.kdprov='$kdprov' AND periode_evkin.kdkab='$kdkab' AND periode_evkin.kdkec='$kdkec'";
        } else if($month != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all') {
            $where = "WHERE bulan='$month' AND periode_evkin.kdprov='$kdprov' AND periode_evkin.kdkab='$kdkab' AND periode_evkin.kdkec='$kdkec' ";
        } else if ($year != "all" AND $kdprov== 'all' AND $kdkab == 'all' AND $kdkec == 'all') {
            $where = "WHERE tahun='$year'";
        }  else if($year != "all" AND $kdprov!= 'all' AND $kdkab == 'all' AND $kdkec == 'all') {
            $where = "WHERE tahun='$year' AND periode_evkin.kdprov='$kdprov'";
        }  else if($year != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec == 'all') {
            $where = "WHERE tahun='$year' AND periode_evkin.kdprov='$kdprov' AND periode_evkin.kdkab='$kdkab'";
        }  else if($year != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all') {
            $where = "WHERE tahun='$year' AND periode_evkin.kdprov='$kdprov' AND periode_evkin.kdkab='$kdkab' AND periode_evkin.kdkec='$kdkec'";
        } else if($year != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' ) {
            $where = "WHERE tahun='$year' AND periode_evkin.kdprov='$kdprov' AND periode_evkin.kdkab='$kdkab' AND periode_evkin.kdkec='$kdkec' ";
        } else if($month == "all" AND $kdprov!= 'all' AND $kdkab == 'all' AND $kdkec == 'all') {
            $where = "WHERE periode_evkin.kdprov='$kdprov'";
        } else if($month == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec == 'all') {
            $where = "WHERE periode_evkin.kdprov='$kdprov' AND periode_evkin.kdkab='$kdkab'";
        } else if($month == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all') {
            $where = "WHERE periode_evkin.kdprov='$kdprov' AND periode_evkin.kdkab='$kdkab' AND periode_evkin.kdkec='$kdkec'";
        } else if($month == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all') {
            $where = "WHERE periode_evkin.kdprov='$kdprov' AND periode_evkin.kdkab='$kdkab' AND periode_evkin.kdkec='$kdkec' ";//
        } else if($year == "all" AND $kdprov!= 'all' AND $kdkab == 'all' AND $kdkec == 'all') {
            $where = "WHERE periode_evkin.kdprov='$kdprov'";
        } else if($year == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec == 'all') {
            $where = "WHERE periode_evkin.kdprov='$kdprov' AND periode_evkin.kdkab='$kdkab'";
        } else if($year == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all') {
            $where = "WHERE periode_evkin.kdprov='$kdprov' AND periode_evkin.kdkab='$kdkab' AND periode_evkin.kdkec='$kdkec'";
        } else if($year == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all') {
            $where = "WHERE periode_evkin.kdprov='$kdprov' AND periode_evkin.kdkab='$kdkab' AND periode_evkin.kdkec='$kdkec' ";
        } else if($month != "all" AND $year != "all" AND $kdprov!= 'all' AND $kdkab != 'all') {
            $where = "WHERE bulan='$month' AND tahun='$year' periode_evkin.kdprov='$kdprov' AND periode_evkin.kdkab='$kdkab' AND periode_evkin.kdkec='$kdkec' ";
        } else {
            $where = '';
        }

        if($user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;

            $data  = DB::select( DB::raw("SELECT *, periode_evkin.id AS id FROM periode_evkin LEFT JOIN users ON users.id = periode_evkin.user_id LEFT JOIN departments ON departments.id = users.department_id LEFT JOIN wilayah_provinsi ON users.kdprov = wilayah_provinsi.kdprov LEFT JOIN wilayah_kabupaten ON users.kdkab=wilayah_kabupaten.kdkab LEFT JOIN wilayah_kecamatan ON users.kdkec = wilayah_kecamatan.kdkec  $where  ORDER BY periode_evkin.id DESC LIMIT $total, $limit "));
            $count  = DB::select( DB::raw("SELECT COUNT(periode_evkin.id) AS id FROM periode_evkin  LEFT JOIN users ON users.id = periode_evkin.user_id $where"))['0']->id;

            $total_page = ceil($count / $limit);

            if($total_page == 0) {
                $total_page = 1;
            }   

            return response()->json(['status' => 'success' ,'data' => $data, 'count' => $count, 'total_page' => $total_page, 'total' => $total]);
            
        } else {

            return redirect('sign-in');
        }
        
    } 

    public function addData(Request $request)
    {
        $rules = array(
            'bulan'    =>  'required',
            'tahun'    =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $id_user = Auth::user()->id;
        $department = Auth::user()->department_id;
        $kdprov = Auth::user()->kdprov;
        $kdkab = Auth::user()->kdkab;
        $kdkec = Auth::user()->kdkec;

        $check_periode = DB::select( DB::raw("SELECT * FROM periode_evkin WHERE bulan='$request->bulan' AND tahun='$request->tahun' AND user_id='$id_user'"));

        if ($department==7) {
            $peran = 'kader';
        } else if ($department==6) {
            $peran = 'fasdis';
        } else if ($department==5) {
            $peran = 'faskab';
        } else {
            $peran = 'korkab';
        }


        if(empty($check_periode)) {
        

            $form_data = array(
                'user_id'        =>  $id_user,
                'bulan'        =>  $request->bulan,
                'tahun'        =>  $request->tahun,
                'peran'        =>  $peran,
                'kdprov'        =>  $kdprov,
                'kdkab'        =>  $kdkab,
                'kdkec'        =>  $kdkec,
            );

            Periodeevkin::create($form_data);

            $id_periode = DB::select( DB::raw("SELECT max(ID) AS id_periode FROM periode_evkin"))['0']->id_periode;

            if(Auth::user()->is_admin == 1) {
                $query = DB::select( DB::raw("SELECT id FROM users WHERE department_id=5"));
            } else {

                if(Auth::user()->department_id == 7) {
                    $kdkec = Auth::user()->kdkec;
                    $query = DB::select( DB::raw("SELECT id FROM users WHERE is_admin = 0 AND role_id !=2 AND kdkec = '$kdkec' AND department_id=8"));
                }

                if(Auth::user()->department_id == 6) {
                    $kdkab = Auth::user()->kdkab;
                    $query = DB::select( DB::raw("SELECT id FROM users WHERE is_admin = 0 AND role_id !=2 AND kdkab = '$kdkab' AND department_id=7"));
                }

                if(Auth::user()->department_id == 5) {
                    $kdprov = Auth::user()->kdprov;
                    $query = DB::select( DB::raw("SELECT id FROM users WHERE is_admin = 0 AND role_id !=2 AND kdkab = '$kdkab' AND department_id=6"));
                }

                if(Auth::user()->department_id == 33) {
                    $kdkab = Auth::user()->kdkab;
                    $query = DB::select( DB::raw("SELECT id FROM users WHERE is_admin = 0 AND role_id !=2 AND kdkab = '$kdkab' AND department_id=5"));
                }

                if(Auth::user()->department_id == 27) {
                    $kdkab = Auth::user()->kdkab;
                    $query = DB::select( DB::raw("SELECT id FROM users WHERE is_admin = 0 AND role_id !=2 AND kdkab = '$kdkab' AND department_id=5"));
                }
                
            }
            

            foreach($query as $row) {

                $form_data = array(
                    'periode_id'        =>  $id_periode,
                    'user_id'        =>  $row->id,
                    'penilai'        =>  Auth::user()->name,
                );

                Evkin::create($form_data);
            }

            return response()->json(['status' => 'success']);

            

        } else {

            return response()->json(['status' => 'exist']);

        }
    } 


    public function addFasilitatorEvkin(Request $request)
    {
        $form_data = array(
            'periode_id'        =>  $request->periode_id,
            'user_id'        =>  $request->id_user,
            'penilai'        =>  Auth::user()->name,
        );

        Evkin::create($form_data);

        return response()->json(['status' => 'success']);
    }

    public function evkinFasilitator($id)
    {
        $user = Auth::user();
        $periode  = DB::select( DB::raw("SELECT bulan,tahun FROM periode_evkin WHERE id='$id'"));
        $bulan = $periode['0']->bulan;
        $tahun = $periode['0']->tahun;

        $fasilitator  = DB::select( DB::raw("SELECT id, name FROM users WHERE department_id=8 OR department_id=7 OR department_id=6 OR department_id=5 ORDER BY name ASC"));


        if($user) {
            if (Auth::user()->is_admin==1) {

                $id_user  = DB::select( DB::raw("SELECT user_id FROM periode_evkin WHERE id='$id'"))['0']->user_id;

                $users  = DB::select( DB::raw("SELECT name, kdprov, kdkab, kdkec, kddesa, department_id FROM users WHERE id='$id_user'"));

                $name = $users['0']->name;
                $id_depart = $users['0']->department_id;
                $kdprov = $users['0']->kdprov;
                $kdkab = $users['0']->kdkab;
                $kdkec = $users['0']->kdkec;
                $kddesa = $users['0']->kddesa;
                $peran  = DB::select( DB::raw("SELECT title FROM departments WHERE id='$id_depart'"))['0']->title;

                if ($id_depart==7) {
                    $prov  = DB::select( DB::raw("SELECT nmprov FROM wilayah_provinsi WHERE kdprov='$kdprov'"))['0']->nmprov;
                    $kab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab='$kdkab'"))['0']->nmkab;
                    $kec  = DB::select( DB::raw("SELECT nmkec FROM wilayah_kecamatan WHERE kdkec='$kdkec'"))['0']->nmkec;
                    $desa  = '';
                } else if ($id_depart==6 || $id_depart==5) {
                    $prov  = DB::select( DB::raw("SELECT nmprov FROM wilayah_provinsi WHERE kdprov='$kdprov'"))['0']->nmprov;
                    $kab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab='$kdkab'"))['0']->nmkab;
                    $kec = '';
                    $desa = '';
                } else {
                    $prov  = 'NPMU PUSAT';
                    $kab  = '';
                    $kec = '';
                    $desa = '';
                }

                return view('drp.admin.evkin-admin', compact('prov', 'kab', 'kec', 'desa', 'name', 'peran', 'id_depart', 'bulan','tahun', 'fasilitator'));
                
            } else {



                $kdprov = Auth::user()->kdprov;
                $kdkab = Auth::user()->kdkab;
                $kdkec = Auth::user()->kdkec;
                $kddesa = Auth::user()->kddesa;
                $id_depart = Auth::user()->department_id;
                
                if ($id_depart==7) {
                    $provinsi  = DB::select( DB::raw("SELECT nmprov FROM wilayah_provinsi WHERE kdprov='$kdprov'"))['0']->nmprov;
                    $kab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab='$kdkab'"))['0']->nmkab;
                    $kec  = DB::select( DB::raw("SELECT nmkec FROM wilayah_kecamatan WHERE kdkec='$kdkec'"))['0']->nmkec;
                    $desa  = '';
                } else if ($id_depart==6 || $id_depart==5) {
                    $provinsi  = DB::select( DB::raw("SELECT nmprov FROM wilayah_provinsi WHERE kdprov='$kdprov'"))['0']->nmprov;
                    $kab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab='$kdkab'"))['0']->nmkab;
                    $kec = '';
                    $desa = '';
                } else if ($id_depart==33 || $id_depart==27) {
                    $provinsi  = DB::select( DB::raw("SELECT nmprov FROM wilayah_provinsi WHERE kdprov='$kdprov'"))['0']->nmprov;
                    $kab  = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab='$kdkab'"))['0']->nmkab;
                    $kec = '';
                    $desa = '';
                }

                return view('drp.admin.evkin-fasilitator', compact('provinsi', 'kab', 'kec', 'desa','bulan','tahun'));    
            }
            
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function getEvkinFasilitator(Request $request, $page, $limit, $id, $search)
    {
        $user = Auth::user();

        if ($search != "all") {
            $where = "AND users.name LIKE '%$search%'";
        } else {
            $where = "";
        }

        if($user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;

            if (Auth::user()->is_admin==1) {

                $id_user  = DB::select( DB::raw("SELECT user_id FROM periode_evkin WHERE id='$id'"))['0']->user_id;
                $id_peran  = DB::select( DB::raw("SELECT department_id FROM users WHERE id='$id_user'"))['0']->department_id;


                if ($id_peran=='7') {
                    $data  = DB::select( DB::raw("SELECT *, wilayah_desa.nmdesa AS wilayah ,evkin.id AS id_main FROM evkin LEFT JOIN users ON users.id = evkin.user_id LEFT JOIN wilayah_desa ON users.kddesa = wilayah_desa.kddesa WHERE periode_id = '$id' $where ORDER BY name ASC LIMIT $total, $limit "));
                } elseif($id_peran=='6') {
                    $data  = DB::select( DB::raw("SELECT *, wilayah_kecamatan.nmkec AS wilayah,evkin.id AS id_main FROM evkin LEFT JOIN users ON users.id = evkin.user_id LEFT JOIN wilayah_kecamatan ON users.kdkec = wilayah_kecamatan.kdkec WHERE periode_id = '$id' $where ORDER BY name ASC LIMIT $total, $limit "));
                } else {
                    $data  = DB::select( DB::raw("SELECT *, wilayah_kabupaten.nmkab AS wilayah,evkin.id AS id_main FROM evkin LEFT JOIN users ON users.id = evkin.user_id LEFT JOIN wilayah_kabupaten ON users.kdkab = wilayah_kabupaten.kdkab WHERE periode_id = '$id' $where ORDER BY name ASC LIMIT $total, $limit "));
                }

            } else {

                // if (Auth::user()->department_id=='7') {
                //     $data  = DB::select( DB::raw("SELECT *, wilayah_desa.nmdesa AS wilayah ,evkin.id AS id_main FROM evkin LEFT JOIN users ON users.id = evkin.user_id LEFT JOIN wilayah_desa ON users.kddesa = wilayah_desa.kddesa WHERE periode_id = '$id' $where ORDER BY name ASC LIMIT $total, $limit "));
                // } else if (Auth::user()->department_id=='6') {
                //     $data  = DB::select( DB::raw("SELECT *, wilayah_kecamatan.nmkec AS wilayah,evkin.id AS id_main FROM evkin LEFT JOIN users ON users.id = evkin.user_id LEFT JOIN wilayah_kecamatan ON users.kdkec = wilayah_kecamatan.kdkec WHERE periode_id = '$id' $where ORDER BY name ASC LIMIT $total, $limit "));
                // } else if (Auth::user()->department_id=='5') {
                //     $data  = DB::select( DB::raw("SELECT *, wilayah_kabupaten.nmkab AS wilayah,evkin.id AS id_main FROM evkin LEFT JOIN users ON users.id = evkin.user_id LEFT JOIN wilayah_kabupaten ON users.kdkab = wilayah_kabupaten.kdkab WHERE periode_id = '$id' $where ORDER BY name ASC LIMIT $total, $limit "));
                // } else {
                //     $data  = DB::select( DB::raw("SELECT *, wilayah_kabupaten.nmkab AS wilayah,evkin.id AS id_main FROM evkin LEFT JOIN users ON users.id = evkin.user_id LEFT JOIN wilayah_kabupaten ON users.kdkab = wilayah_kabupaten.kdkab WHERE periode_id = '$id' $where ORDER BY name ASC LIMIT $total, $limit "));
                // }

                $data  = DB::select( DB::raw("SELECT *, evkin.id AS id_main FROM evkin LEFT JOIN users ON users.id = evkin.user_id LEFT JOIN wilayah_kabupaten ON users.kdkab = wilayah_kabupaten.kdkab LEFT JOIN wilayah_kecamatan ON users.kdkec = wilayah_kecamatan.kdkec LEFT JOIN wilayah_desa ON users.kddesa = wilayah_desa.kddesa WHERE periode_id = '$id' $where ORDER BY name ASC LIMIT $total, $limit "));
            }
            
            $count  = DB::select( DB::raw("SELECT COUNT(evkin.id) AS id FROM evkin LEFT JOIN users ON users.id = evkin.user_id WHERE periode_id = '$id' $where"))['0']->id;

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

        $peran = DB::select( DB::raw("SELECT department_id FROM users WHERE id='$id_user'"))['0']->department_id;

        if($user) {
            
            $check = DB::select( DB::raw("SELECT nilai FROM evkin WHERE periode_id='$id_periode' AND user_id='$id_user'"))['0']->nilai;

            if($check) {
                $evkin = DB::select( DB::raw("SELECT * FROM evkin WHERE periode_id='$id_periode' AND user_id='$id_user'"));
                $check = DB::select( DB::raw("SELECT bulan,tahun FROM periode_evkin WHERE id='$id_periode'"));
                $bulan = $check['0']->bulan;
                $tahun = $check['0']->tahun;


                $attendance = DB::select( DB::raw("SELECT * FROM attendances WHERE user_id='$id_user' AND month(date)='$bulan' AND year(date) = '$tahun'  ORDER BY id DESC"));
                $aktivitas = DB::select( DB::raw("SELECT * FROM daily_activity WHERE created_by='$id_user' AND month(date)='$bulan' AND year(date) = '$tahun' ORDER BY id DESC"));

                if ($bulan=='01') {
                    $name = 'Januari';
                } else if ($bulan=='02') {
                    $name = 'Februari';
                } else if ($bulan=='03') {
                    $name = 'Maret';
                } else if ($bulan=='04') {
                    $name = 'April';
                } else if ($bulan=='05') {
                    $name = 'Mei';
                } else if ($bulan=='06') {
                    $name = 'Juni';
                } else if ($bulan=='07') {
                    $name = 'Juli';
                } else if ($bulan=='08') {
                    $name = 'Agustus';
                } else if ($bulan=='09') {
                    $name = 'September';
                } else if ($bulan=='10') {
                    $name = 'Oktober';
                } else if ($bulan=='11') {
                    $name = 'November';
                } else if ($bulan=='12') {
                    $name = 'Desember';
                }

                $bulanan = DB::select( DB::raw("SELECT * FROM monthly_report WHERE user_id='$id_user' AND month='$name' AND year='$tahun' ORDER BY id DESC"));

                return view('drp.admin.detail-nilai-evkin', compact('evkin', 'attendance', 'aktivitas', 'bulanan', 'peran'));

            } else {

                $check = DB::select( DB::raw("SELECT bulan,tahun FROM periode_evkin WHERE id='$id_periode'"));
                $bulan = $check['0']->bulan;
                $tahun = $check['0']->tahun;

                $attendance = DB::select( DB::raw("SELECT * FROM attendances WHERE user_id='$id_user' AND month(date)='$bulan' AND year(date) = '$tahun'  ORDER BY id DESC"));
                $aktivitas = DB::select( DB::raw("SELECT * FROM daily_activity WHERE created_by='$id_user' AND month(date)='$bulan' AND year(date) = '$tahun' ORDER BY id DESC"));
                if ($bulan=='01') {
                    $name = 'Januari';
                } else if ($bulan=='02') {
                    $name = 'Februari';
                } else if ($bulan=='03') {
                    $name = 'Maret';
                } else if ($bulan=='04') {
                    $name = 'April';
                } else if ($bulan=='05') {
                    $name = 'Mei';
                } else if ($bulan=='06') {
                    $name = 'Juni';
                } else if ($bulan=='07') {
                    $name = 'Juli';
                } else if ($bulan=='08') {
                    $name = 'Agustus';
                } else if ($bulan=='09') {
                    $name = 'September';
                } else if ($bulan=='10') {
                    $name = 'Oktober';
                } else if ($bulan=='11') {
                    $name = 'November';
                } else if ($bulan=='12') {
                    $name = 'Desember';
                }

                $bulanan = DB::select( DB::raw("SELECT * FROM monthly_report WHERE user_id='$id_user' AND month='$name' AND year='$tahun' ORDER BY id DESC"));

                return view('drp.admin.nilai-fasilitator', compact('attendance', 'aktivitas', 'bulanan', 'peran'));
            }

            
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function editnilaiFasilitator($id_periode, $id_user)
    {
        $user = Auth::user();

        $peran = DB::select( DB::raw("SELECT department_id FROM users WHERE id='$id_user'"))['0']->department_id;
        $evkin = DB::select( DB::raw("SELECT * FROM evkin WHERE periode_id='$id_periode' AND user_id='$id_user'"));

        if($user) {

            $check = DB::select( DB::raw("SELECT bulan,tahun FROM periode_evkin WHERE id='$id_periode'"));
            $bulan = $check['0']->bulan;
            $tahun = $check['0']->tahun;

            $attendance = DB::select( DB::raw("SELECT * FROM attendances WHERE user_id='$id_user' AND month(date)='$bulan' AND year(date) = '$tahun'  ORDER BY id DESC"));
            $aktivitas = DB::select( DB::raw("SELECT * FROM daily_activity WHERE created_by='$id_user' AND month(date)='$bulan' AND year(date) = '$tahun' ORDER BY id DESC"));
            if ($bulan=='01') {
                $name = 'Januari';
            } else if ($bulan=='02') {
                $name = 'Februari';
            } else if ($bulan=='03') {
                $name = 'Maret';
            } else if ($bulan=='04') {
                $name = 'April';
            } else if ($bulan=='05') {
                $name = 'Mei';
            } else if ($bulan=='06') {
                $name = 'Juni';
            } else if ($bulan=='07') {
                $name = 'Juli';
            } else if ($bulan=='08') {
                $name = 'Agustus';
            } else if ($bulan=='09') {
                $name = 'September';
            } else if ($bulan=='10') {
                $name = 'Oktober';
            } else if ($bulan=='11') {
                $name = 'November';
            } else if ($bulan=='12') {
                $name = 'Desember';
            }

            $bulanan = DB::select( DB::raw("SELECT * FROM monthly_report WHERE user_id='$id_user' AND month='$name' AND year='$tahun' ORDER BY id DESC"));

            return view('drp.admin.edit-nilai-fasilitator', compact('attendance', 'aktivitas', 'bulanan', 'peran', 'evkin'));
            
            
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

        if (empty($query['0']->kdkec)) {
            $kdkec = '';
            $kec = '';
        } else {
            $kdkec = $query['0']->kdkec;
            $kec = DB::select( DB::raw("SELECT nmkec FROM wilayah_kecamatan WHERE kdkec='$kdkec'"))['0']->nmkec;
        }

        if (empty($query['0']->kddesa)) {
            $kddesa = '';
            $desa = '';
        } else {
            $kddesa = $query['0']->kddesa;
            $desa = DB::select( DB::raw("SELECT nmdesa FROM wilayah_desa WHERE kddesa='$kddesa'"))['0']->nmdesa;
        }
        
        
        $id_unit = $query['0']->department_id;

        $unit = DB::select( DB::raw("SELECT title FROM departments WHERE id='$id_unit'"))['0']->title;
        $prov = DB::select( DB::raw("SELECT nmprov FROM wilayah_provinsi WHERE kdprov='$kdprov'"))['0']->nmprov;        
        $kab = DB::select( DB::raw("SELECT nmkab FROM wilayah_kabupaten WHERE kdkab='$kdkab'"))['0']->nmkab;

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

        $jml_semua = DB::select( DB::raw("SELECT count(id) AS id FROM evkin WHERE periode_id='$request->id_periode'"))['0']->id;
        $jml_dinilai = DB::select( DB::raw("SELECT count(id) AS id FROM evkin WHERE periode_id='$request->id_periode' AND kehadiran IS NOT NULL"))['0']->id;

        $form_data = array(
            'status' => 1
        );

        if ($jml_semua == $jml_dinilai) {
            Periodeevkin::where('id', $request->id_periode)->update($form_data);
        }


        return response()->json(['status' => 'success']);
    }

    public function evkinSaya(Request $request)
    {
        $user = Auth::user();

        if($user) {

            $tahun  = DB::select( DB::raw("SELECT DISTINCT(tahun) FROM periode_evkin"));

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

            return view('drp.fasilitator.evkin-saya', compact('provinsi', 'kab', 'kec', 'desa', 'tahun'));
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function getEvkinSaya(Request $request, $page, $limit, $month, $year)
    {
        $user = Auth::user();
        $id_user = Auth::user()->id;
        if ($month != "all" AND $year =='all') {
            $where = "AND bulan='$month'";
        } else if ($month == "all" AND $year !='all') {
            $where = "AND tahun='$year'";
        } else if ($month != "all" AND $year !='all') {
            $where = "AND bulan='$month' AND tahun='$year'";
        }  else {
            $where = "";
        }

        if($user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;

            $data  = DB::select( DB::raw("SELECT *,users.name AS penilai, periode_evkin.id AS id FROM evkin LEFT JOIN periode_evkin ON evkin.periode_id = periode_evkin.id LEFT JOIN users ON periode_evkin.user_id = users.id WHERE evkin.user_id='$id_user' $where  ORDER BY evkin.id DESC LIMIT $total, $limit "));
            $count  = DB::select( DB::raw("SELECT COUNT(evkin.id) AS id FROM evkin LEFT JOIN periode_evkin ON evkin.periode_id = periode_evkin.id WHERE evkin.user_id='$id_user' $where"))['0']->id;

            $total_page = ceil($count / $limit);

            if($total_page == 0) {
                $total_page = 1;
            }   

            return response()->json(['status' => 'success' ,'data' => $data, 'count' => $count, 'total_page' => $total_page, 'total' => $total]);
            
        } else {

            return redirect('sign-in');
        }
        
    } 

    public function deleteEvkin(Request $request) {

        $id = $request->id_delete;
        
        DB::select( DB::raw("DELETE FROM  periode_evkin WHERE id='$id'"));
        DB::select( DB::raw("DELETE FROM  evkin WHERE periode_id='$id'"));
        return response()->json(['status' => 'success']);
    }


    public function deleteFasilitatorEvkin(Request $request) {

        $id = $request->id_delete;
        DB::select( DB::raw("DELETE FROM evkin WHERE id='$id'"));
        return response()->json(['status' => 'success']);
    }

    
        
    
}
