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

class FasilitatorController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();

        if($user) {
            $provinsi  = DB::select( DB::raw("SELECT * FROM wilayah_provinsi ORDER BY nmprov ASC"));
            return view('drp.admin.daftar-fasilitator', compact('provinsi'));
            
        } else {

            return redirect('sign-in');
        }
        
    }
    

    public function getFasilitator(Request $request, $page, $limit, $search, $kdprov, $kdkab, $kdkec, $kddesa)
    {
        $user = Auth::user();
        if ($search != "all" AND $kdprov== 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $where = "WHERE users.name LIKE '%" . $search . "%'";
        }  else if($search != "all" AND $kdprov!= 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $where = "WHERE users.name LIKE '%" . $search . "%' AND users.kdprov='$kdprov'";
        }  else if($search != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec == 'all' AND $kddesa=='all') {
            $where = "WHERE users.name LIKE '%" . $search . "%' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab'";
        }  else if($search != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa=='all') {
            $where = "WHERE users.name LIKE '%" . $search . "%' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec'";
        } else if($search != "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa!='all') {
            $where = "WHERE users.name LIKE '%" . $search . "%' AND users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec' AND users.kddesa='$kddesa'";
        } else if($search == "all" AND $kdprov!= 'all' AND $kdkab == 'all' AND $kdkec == 'all' AND $kddesa =='all') {
            $where = "WHERE users.kdprov='$kdprov'";
        } else if($search == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec == 'all' AND $kddesa =='all') {
            $where = "WHERE users.kdprov='$kdprov' AND users.kdkab='$kdkab'";
        } else if($search == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa =='all') {
            $where = "WHERE users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec'";
        } else if($search == "all" AND $kdprov!= 'all' AND $kdkab != 'all' AND $kdkec != 'all' AND $kddesa !='all') {
            $where = "WHERE users.kdprov='$kdprov' AND users.kdkab='$kdkab' AND users.kdkec='$kdkec' AND users.kddesa='$kddesa'";
        } else {
            $where = '';
        }

        
        // if($id_prov!='all' || $id_kab!='all' || $id_kec!='all' || $id_desa!='all') {
        //     $where = "WHERE kdprov='$id_prov' OR kdkab='$id_kab' OR kdkec='$id_kec' OR kddesa='$id_desa'";
        // } else {
        //     $where = "";
        // }
                

        if($user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;
            $isadmin = Auth::user()->is_admin;

            if($isadmin==1) {

                $data  = DB::select( DB::raw("SELECT *, users.status_id AS status_id FROM users LEFT JOIN departments ON users.department_id = departments.id LEFT JOIN wilayah_provinsi ON users.kdprov = wilayah_provinsi.kdprov LEFT JOIN wilayah_kabupaten ON users.kdkab=wilayah_kabupaten.kdkab LEFT JOIN wilayah_kecamatan ON users.kdkec = wilayah_kecamatan.kdkec LEFT JOIN wilayah_desa ON users.kddesa = wilayah_desa.kddesa $where  ORDER BY users.id DESC LIMIT $total, $limit "));
                $count  = DB::select( DB::raw("SELECT COUNT(id) AS id FROM users $where "))['0']->id;
            
                $total_page = ceil($count / $limit);

                if($total_page == 0) {
                    $total_page = 1;
                }   

                return response()->json(['status' => 'success' ,'data' => $data, 'count' => $count, 'total_page' => $total_page, 'total' => $total]);

            } 
            
        } else {

            return redirect('sign-in');
        }
        
    } 
    
}
