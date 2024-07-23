<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function getDemoLoginData()
    {
        $users = [];
        // distinct role wise login button enabled
        if (config('app.style') === 'demo') {
            $users = User::active()->join('roles', 'users.role_id', '=', 'roles.id')
                ->select('users.email', 'roles.name')
                ->distinct()
                ->get();
        }
        return $users;
    }

    public function adminLogin()
    {

        $users = [];
        try {
            if (Auth::check()) {
                return redirect('dashboard');
            }
            $users = $this->getDemoLoginData();

            return view('backend.auth.admin_login', compact('users'));
        } catch (\Throwable $th) {
            dd($th);
            Toastr::error(_trans('response.Something went wrong'), 'Error');
            return redirect('/');
        }
    }

    public function LoginForm()
    {
        return view('backend.auth.admin_login');
    }
}
