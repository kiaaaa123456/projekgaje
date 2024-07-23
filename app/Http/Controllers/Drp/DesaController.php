<?php

namespace App\Http\Controllers\Drp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Desa;
use Validator;
use DB;
use Hash;
use Signature;
use Illuminate\Support\Facades\Auth;

class DesaController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();

        if($user) {

            return view('drp.admin.desa');
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function getDesa(Request $request, $page, $limit, $search)
    {
        $user = Auth::user();

        if ($search != "all") {
            $where = "WHERE nmkec LIKE '%" . $search . "%' OR nmdesa LIKE '%" . $search . "%'";
        } else {
            $where = "";
        }

        if($user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;

            $data  = DB::select( DB::raw("SELECT * FROM wilayah_desa LEFT JOIN wilayah_kecamatan ON wilayah_desa.kdkec = wilayah_kecamatan.kdkec $where ORDER BY nmkec ASC LIMIT $total, $limit "));
            $count  = DB::select( DB::raw("SELECT COUNT(kddesa) AS id FROM wilayah_desa LEFT JOIN wilayah_kecamatan ON wilayah_desa.kdkec = wilayah_kecamatan.kdkec $where"))['0']->id;

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
            CURLOPT_URL => 'https://tekad.kemendesa.go.id/monev/api/mswildesa?email=guest%40alfanumerik.co.id&token=tekad-guest-2023',
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
                    'kddesa'        =>  $row['kddesa'],
                    'kdkec'        =>  $row['kdkec'],
                    'nmdesa'        =>  $row['nmdesa'],
                    'is_primary'        =>  $row['is_primary'],
                    'catatan'        =>  $row['catatan'],
                    'target_pm'        =>  $row['target_pm'],
                    'target_kk'        =>  $row['target_kk'],
                    'is_primary_text'        =>  $row['is_primary_text'],
                );

                Desa::create($form_data);
            }

        } else {
            return redirect('sign-in');
        }

        
        
    }
}
