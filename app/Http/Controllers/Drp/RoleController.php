<?php

namespace App\Http\Controllers\Drp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Validator;
use DB;
use Hash;
use Signature;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    
    public function index(Request $request)
    {
        $user = Auth::user();

        if($user) {

            return view('drp.admin.role');
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function getRole(Request $request, $page, $limit, $search)
    {
        $user = Auth::user();

        if ($search != "all") {
            $where = "WHERE displayname LIKE '%" . $search . "%' OR rolename LIKE '%" . $search . "%'";
        } else {
            $where = "";
        }

        if($user) {

            $page_ = $page - 1;
            $total = $page_ * $limit;

            $data  = DB::select( DB::raw("SELECT * FROM role $where  ORDER BY roleid ASC LIMIT $total, $limit "));
            $count  = DB::select( DB::raw("SELECT COUNT(roleid) AS id FROM role $where"))['0']->id;

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
            CURLOPT_URL => 'https://alfanumerik-lab.com/tekad_2023/monev/api/sysrole?email=guest@alfanumerik.co.id&token=tekad-guest-2023',
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
                    'roleid'        =>  $row['roleid'],
                    'rolename'        =>  $row['rolename'],
                    'displayname'        =>  $row['displayname'],
                    'description'        =>  $row['description'],
                    'prov'        =>  $row['prov'],
                    'kab'        =>  $row['kab'],
                    'kec'        =>  $row['kec'],
                    'desa'        =>  $row['desa'],
                    'sortno'        =>  $row['sortno'],
                    'group'        =>  $row['group'],
                    'show_on_register'        =>  $row['show_on_register'],
                );

                Role::create($form_data);
            }

        } else {
            return redirect('sign-in');
        }
        
    }

    public function listRole(Request $request)
    {
        $data  = DB::select( DB::raw("SELECT * FROM role  ORDER BY roleid ASC "));
        echo json_encode($data );
    }
}
