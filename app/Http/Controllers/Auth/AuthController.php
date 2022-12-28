<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PersonalToken;
use App\Models\User;
use App\Models\verificationCode;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use GeneralTrait;
    use AuthTrait;


    public function testEmail(Request $request){
        $data = ['subject' => 'verfiy email' , 'view' => 'verfiyEmail' , 'data' => ['code' =>  '123456']];
        return $this->sendEmail($request, $data);
    }

    public function resetPassword(Request $request){
        $res = $this->generalCheckVerifyCode($request,'user');
        if(!$res->getData()->status){
            return $res;
        }
        $Validator = Validator::make($request->all(),[
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if ($Validator->fails()) {
            return $this->returnValidationError('validation error occur', $Validator->errors(), 422);
        }
        $user = User::where('email',$request->email)->first();
        if($user){
            $user->update(['password' => Hash::make($request->password)]);
            return $this->returnSuccessMessage("Reset password Success");
        }
        return $this->returnError(429,'Something error occur');
    }

    public function checkVerifyCode(Request $request){
        return $this->generalCheckVerifyCode($request,'user');
    }

    public function sendCodeToEmail(Request $request){
        $Validator = Validator::make($request->all(),[
            'email' => 'required|email'
        ]);
        if ($Validator->fails()) {
            return $this->returnValidationError('validation error occur', $Validator->errors(), 422);
        }
        $user = User::where('email',$request->email)->first();
        if(!$user){
            return $this->returnError(429,"Your Email does not Exist. enter correct email");
        }
        return $this->sendCode($request,'user');
    }



    public function sendVerifyEmail(Request $request){
        $validate =[
            'first_name' => ['required', 'string', 'min:2', 'max:50'],
            'last_name' => ['required', 'string', 'min:2', 'max:50'],
            'username' => ['required', 'string', 'unique:users,username', 'min:5', 'max:10'],
            'email' => ['email', 'required', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
        return $this->generalSendVerifyEmail($request,$validate,'user');
    }


    //Forget your password

    //validate email exist
    //generate random number
    //send verify code email
    //show to enter code
    //send request(email , code) to check
    //if not correct
    //show error message invalid code with options(resend code , change email)
    //if correct
    //show input reset code
    //after submit update password value in DB

    public function register(Request $request)
    {
        $createData = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];
        $regValidate = [
            'first_name' => ['required', 'string', 'min:2', 'max:50'],
            'last_name' => ['required', 'string', 'min:2', 'max:50'],
            'username' => ['required', 'string', 'unique:users,username', 'min:5', 'max:10'],
            'email' => ['email', 'required', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
        return $this->generalRegister($request,$regValidate,$createData,'user');
    }
    public function login(Request $request)
    {
        return $this->generalLogin($request,'user');
    }

    public function logout(Request $request)
    {
        $token = PersonalToken::findOrFail($request->token['id']);
        $token->delete();
        return $this->returnSuccessMessage('Logout successful');
    }

    public function checkToken(Request $request){
        return $this->checkTokenInfo($request);
    }
}