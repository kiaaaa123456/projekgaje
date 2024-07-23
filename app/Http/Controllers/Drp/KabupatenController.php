<?php

namespace App\Http\Controllers\Drp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kabupaten;
use Validator;
use DB;
use Hash;
use Signature;
use Illuminate\Support\Facades\Auth;

class KabupatenController extends Controller
{
    
    public function index(Request $request)
    {
        $user = Auth::user();

        if($user) {

            return view('drp.admin.kabupaten');
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function getKabupaten(Request $request, $page, $limit, $search)
    {
        $user = Auth::user();

        if ($search != "all") {
            $where = "WHERE nmprov LIKE '%" . $search . "%' OR nmkab LIKE '%" . $search . "%'";
        } else {
            $where = "";
        }

        if($user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;

            $data  = DB::select( DB::raw("SELECT * FROM wilayah_kabupaten LEFT JOIN wilayah_provinsi ON wilayah_kabupaten.kdprov = wilayah_provinsi.kdprov $where ORDER BY nmprov ASC LIMIT $total, $limit "));
            $count  = DB::select( DB::raw("SELECT COUNT(kdkab) AS id FROM wilayah_kabupaten LEFT JOIN wilayah_provinsi ON wilayah_kabupaten.kdprov = wilayah_provinsi.kdprov $where"))['0']->id;

            $total_page = ceil($count / $limit);

            if($total_page == 0) {
                $total_page = 1;
            }   

            return response()->json(['status' => 'success' ,'data' => $data, 'count' => $count, 'total_page' => $total_page, 'total' => $total]);
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function getData(Request $request)
    {
        
        $user = Auth::user();
        if($user) {
            
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://tekad.kemendesa.go.id/monev/api/mswilkab?email=guest%40alfanumerik.co.id&token=tekad-guest-2023',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $convert = json_decode($response,true);
            // dd($convert);
            foreach($convert as $key => $row) {
                
                $form_data = array(
                    'kdkab'        =>  $row['kdkab'],
                    'kdprov'        =>  $row['kdprov'],
                    'nmkab'        =>  $row['nmkab'],
                    'is_primary'        =>  $row['is_primary'],
                    'catatan'        =>  $row['catatan'],
                    'is_primary_text'        =>  $row['is_primary_text'],
                );

                Kabupaten::create($form_data);
            }

        } else {
            return redirect('sign-in');
        }

        
        
    }
}
