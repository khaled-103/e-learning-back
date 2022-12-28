<?php

namespace App\Http\Controllers\Orgnaiztion\Auth;

use App\Http\Controllers\Controller;
use App\Models\Orgnaization;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthOrgController extends Controller
{
    use GeneralTrait;
    use AuthTrait;
    public function checkVerifyCode(Request $request){
        return $this->generalCheckVerifyCode($request,'orgnaization');
    }

    public function resetPassword(Request $request){
        $res = $this->generalCheckVerifyCode($request,'orgnaization');
        if(!$res->getData()->status){
            return $res;
        }
        $Validator = Validator::make($request->all(),[
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if ($Validator->fails()) {
            return $this->returnValidationError('validation error occur', $Validator->errors(), 422);
        }
        $user = Orgnaization::where('email',$request->email)->first();
        if($user){
            $user->update(['password' => Hash::make($request->password)]);
            return $this->returnSuccessMessage("Reset password Success");
        }
        return $this->returnError(429,'Something error occur');
    }

    public function sendCodeToEmail(Request $request){
        $Validator = Validator::make($request->all(),[
            'email' => 'required|email'
        ]);
        if ($Validator->fails()) {
            return $this->returnValidationError('validation error occur', $Validator->errors(), 422);
        }
        $user = Orgnaization::where('email',$request->email)->first();
        if(!$user){
            return $this->returnError(429,"Your Email does not Exist. enter correct email");
        }
        return $this->sendCode($request,'orgnaization');
    }

    public function sendVerifyEmail(Request $request){
        $validate =[
            'name' => ['required', 'string', 'min:2', 'max:50', 'unique:orgnaizations,name'],
            'username' => ['required', 'string', 'unique:orgnaizations,username', 'min:5', 'max:10'],
            'email' => ['email', 'required', 'unique:orgnaizations,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'numeric']
        ];
        return $this->generalSendVerifyEmail($request,$validate,'orgnaization');
    }
    public function register(Request $request)
    {
        $createData = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ];
        $regValidate = [
            'name' => ['required', 'string', 'min:2', 'max:50', 'unique:orgnaizations,name'],
            'username' => ['required', 'string', 'unique:orgnaizations,username', 'min:5', 'max:10'],
            'email' => ['email', 'required', 'unique:orgnaizations,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'numeric']
        ];
        return $this->generalRegister($request, $regValidate, $createData, 'orgnaization');
    }

    public function login(Request $request)
    {
        return $this->generalLogin($request, 'orgnaization');
    }


}
