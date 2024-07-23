<?php

namespace App\Http\Controllers\Drp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Provinsi;
use Validator;
use DB;
use Hash;
use Signature;
use Illuminate\Support\Facades\Auth;

class KonfigurasiController extends Controller
{
    public function syncUser(Request $request)
    {
        $user = Auth::user();

        if($user) {

            return view('drp.admin.sync-user');
            
        } else {

            return redirect('sign-in');
        }
        
    }

    public function backupDb(Request $request)
    {
        $user = Auth::user();

        if($user) {

            return view('drp.admin.backup-db');
            
        } else {

            return redirect('sign-in');
        }
        
    }

    
}
