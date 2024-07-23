<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ProfileRepository;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Validator;
use App\Helpers\CoreApp\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public $token = true;
    protected $profile;

    use ApiReturnFormatTrait;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profile = $profileRepository;
    }

    public function credentials($request)
    {
        if (is_numeric($request->get('email'))) {
            return ['email' => $request->get('email'), 'password' => $request->get('password'), 'is_email' => 0];
        } elseif (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            return ['email' => $request->get('email'), 'password' => $request->get('password'), 'is_email' => 1];
        }
    }

    public function registered(Request $request){


        $rules = array(
            'name'    =>  'required',
            'nik'    =>  'required',
            'email'    =>  'required',
            'department_id'    =>  'required',
            'phone'    =>  'required',
            'kdprov'    =>  'required',
            'kdkab'    =>  'required',
            'kdkec'    =>  'required',
            'kddesa'    =>  'required',
            'birth_date'    =>  'required',
            'gender'    =>  'required',
            'address'    =>  'required',
            'password'    =>  'required',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()], 422);
        }

        // $profileImage = $request->file('backend_image');
        // $profileImageSaveAsName = time() . "-register." . 
        // $profileImage->getClientOriginalExtension();
        // $upload_path = 'image/register/';
        // $profile_image_url = $upload_path . $profileImageSaveAsName;
        // $success = $profileImage->move($upload_path, $profileImageSaveAsName);
       $checkUser = User::where('email',$request->email)->count();
       if($checkUser == 0){
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
            'birth_date'        =>  $request->birth_date,
            'gender'        =>  $request->gender,
            'address'        =>  $request->address,
            'password'        =>  Hash::make($request->password),
            // 'image'        =>  $profile_image_url,
            'company_id'        =>  1,
            'shift_id'        =>  1,
            'role_id'        =>  0,
            // untuk aktivasi akun ,role_id diubah ke 4 oleh admin
        );

        User::create($form_data);
        return $this->responseWithSuccess(__('Registrasi berhasil, akun Anda sedang ditinjau admin.'), $request, 200);
       }else{
        return $this->responseWithSuccess(__('Registrasi gagal, akun Anda sudah terdaftar.'), $request, 400);
       }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'email' => 'required',
                'password' => 'required',
            ]);

        if ($validator->fails()) {
            return $this->responseWithError(__('Required field missing'), $validator->errors(), 422);

        }
        if (isModuleActive('SingleDeviceLogin')) {
            $validator = Validator::make($request->all(),
                [
                    'device_id' => 'required',
                    'device_info' => 'required',
                ]);

            if ($validator->fails()) {
                return $this->responseWithError(__('Required field missing'), $validator->errors(), 422);

            }
        }

        $identifier = filter_var($request->email, FILTER_VALIDATE_EMAIL)? 'email' : 'phone';
        $request->merge(['phone' => $identifier == 'phone' ? $request->email : '']);


        if (!Auth::attempt($request->only([$identifier, 'password']))) {
            return $this->responseWithError(__('Invalid Email or Password'), [], 400);
        }

        $user = User::where($identifier, $request->$identifier)->first();

        if ($user->aktif==0) {
            return $this->responseWithError(__('User not active'), [], 401);
        }

        if (isModuleActive('SingleDeviceLogin')) {
            if ($user) {
                if ($user->device_id == null || $user->device_id == $request->device_id) {
                    $checkUser['id'] = $user->id;
                    $checkUser['company_id'] = $user->company_id;
                    $checkUser['department_id'] = $user->department_id;
                    $checkUser['department_name'] = $user->department->title;
                    $checkUser['is_admin'] = auth()->user()->is_admin ? true : false;
                    $checkUser['is_hr'] = auth()->user()->is_hr ? true : false;
                    $checkUser['is_face_registered'] = auth()->user()->face_data ? true : false;
                    $checkUser['name'] = $user->name;
                    $checkUser['email'] = $user->email;
                    $checkUser['phone'] = $user->phone;
                    $checkUser['avatar'] = uploaded_asset($user->avatar_id);

                    $user->device_id = $request->device_id;
                    $user->device_info = $request->device_info;
                    $user->last_login_device = 'mobile';
                    $user->save();  
                } else {
                    return $this->responseWithError(__('User already registered with another device'), [], 401);
                }
            } else {
                return $this->responseWithError(__('User not found'), [], 401);
            }
        } else {
            $checkUser['id'] = $user->id;
            $checkUser['company_id'] = $user->company_id;
            $checkUser['department_id'] = $user->department_id;
            $checkUser['department_name'] = $user->department->title;
            $checkUser['is_admin'] = auth()->user()->is_admin ? true : false;
            $checkUser['is_hr'] = auth()->user()->is_hr ? true : false;
            $checkUser['is_face_registered'] = auth()->user()->face_data ? true : false;
            $checkUser['name'] = $user->name;
            $checkUser['email'] = $user->email;
            $checkUser['phone'] = $user->phone;
            $checkUser['avatar'] = uploaded_asset($user->avatar_id);
        }

        if ($user->role->app_login == 1) {
            $checkUser['token'] = $user->createToken("API TOKEN")->plainTextToken;

        } else {
            return $this->responseWithError(__('You are not allowed to login to the APP'), [], 400);
        }
        if (isModuleActive('SingleDeviceLogin')) {
            $user->app_token = $checkUser['token'];
        }
        $user->save();

        // exceptional for login
        return $this->responseWithSuccess(__('Successfully Login'), $checkUser, 200);

    }

    public function logout()
    {
        try {
            auth()->user()->currentAccessToken()->delete();
            return $this->responseWithSuccess(__('Logged Out'), [], 200);

        } catch (\Throwable $th) {
            return $this->responseWithError(__('Something Went Wrong! Please Try Again'), [], 400);
        }
    }

    public function logoutAllDevices()
    {
        try {
            auth()->user()->tokens()->delete();
            return $this->responseWithSuccess(__('Successfully Logged Out from All Devices'), [], 200);

        } catch (\Throwable $th) {
            return $this->responseWithError(__('Something Went Wrong! Please Try Again'), [], 400);
        }
    }

    public function getUser(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
        ]);

        $token = PersonalAccessToken::findToken($request->token);
        $user = $token->tokenable;

        return response()->json(['user' => $user]);
    }

    public function sendResetLinkEmail(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            return $this->profile->sendEmail($request);
        } catch (\Exception $exception) {
            return $this->responseWithError($exception->getMessage(), [], 500);
        }

    }

    public function changePassword(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            return $this->profile->updatePassword($request);
        } catch (\Exception $exception) {
            return $this->responseWithError($exception->getMessage(), [], 500);
        }
    }
}
