<?php

namespace App\Traits;

use App\Models\Orgnaization;
use App\Models\PersonalToken;
use App\Models\User;
use App\Models\verificationCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

trait AuthTrait
{


    public function generalCheckVerifyCode(Request $request, $type)
    {
        $Validator = Validator::make($request->all(), [
            'email' => ['email', 'required', 'exists:verification_codes,email'],
            'code' => ['required'],
        ]);
        if ($Validator->fails()) {
            return $this->returnValidationError('validation error occur', $Validator->errors(), 422);
        }
        $res = verificationCode::where('email', $request->email)->where('type', $type)->first();
        if ($res) {
            if (Hash::check($request->code, $res->code))
                return $this->returnSuccessMessage('correct code');
        }
        return $this->returnError(429, 'inCorrect code');
    }

    public function generalSendVerifyEmail(Request $request, $validate, $type)
    {
        $Validator = Validator::make($request->all(), $validate);
        if ($Validator->fails()) {
            return $this->returnValidationError('validation error occur', $Validator->errors(), 422);
        }
        return $this->sendCode($request, $type);
    }
    public function sendCode(Request $request, $type)
    {
        $code = $this->creatCode();
        $data = ['subject' => 'verfiy email', 'view' => 'verfiyEmail', 'data' => ['code' =>  $code]];
        $res = $this->sendEmail($request, $data);
        if ($res->getData()->status) {
            $gUser = verificationCode::where('email', $request->email)->where('type', $type)->first();
            if (!$gUser) {
                verificationCode::create([
                    'email' => $request->email,
                    'code' => Hash::make($code),
                    'type' => $type
                ]);
            } else {
                $gUser->update(['code' => Hash::make($code)]);
            }
        }
        return $this->returnSuccessMessage("we send email");
    }





    public function generalLogin(Request $request, $type)
    {
        $Validator = Validator::make($request->all(), [
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);
        if ($Validator->fails()) {
            return $this->returnValidationError('validation error occur', $Validator->errors(), 422);
        }

        $gUser = null;

        if ($type == 'user') {
            $gUser = User::where('username', $request->username)->orWhere('email', $request->username)->first();
        } else if ($type == 'orgnaization') {
            $gUser = Orgnaization::where('username', $request->username)->orWhere('email', $request->username)->first();
        }

        if ($gUser) {
            if (Hash::check($request->password, $gUser->password)) {
                return $this->returnData('data', [$type => $gUser, 'token' => $this->generateToken($gUser->id, $type)], 'login succcessfuly');
            } else {
                return $this->returnValidationError('validation error occur', ['password' => ['Invalid password']], 422);
            }
        } else {
            return $this->returnValidationError('validation error occur', ['username' => ['Invalid username or email']], 422);
        }
    }

    public function generalRegister(Request $request, $regValidate, $createData, $type)
    {
        $Validator = Validator::make($request->all(), $regValidate);
        if ($Validator->fails()) {
            return $this->returnError(429, 'something wrong !!');
            // return $this->returnValidationError('validation error occur', $Validator->errors(), 422);
        }
        $gUser = null;
        if ($type == 'user') {
            $gUser = User::create($createData);
        } else if ($type == 'orgnaization') {
            $gUser = Orgnaization::create($createData);
        }
        return $this->returnData('data', [$type => $gUser, 'token' => $this->generateToken($gUser->id, $type)], 'new register succcessfuly');
    }
    protected function generateToken($id, $type)
    {
        $token = fake()->uuid();
        $hashToken = Hash::make($token);
        $tokenInfo = PersonalToken::where('tokenable_id', $id)
            ->where('tokenable_type', $type)
            ->first();
        if ($tokenInfo) {
            $tokenInfo->update([
                'token' => $hashToken
            ]);
        } else {
            $tokenInfo = PersonalToken::create([
                'tokenable_type' => $type,
                'tokenable_id' => $id,
                'token' => $hashToken
            ]);
        }
        $tokenInfo['returnedToken'] = $token;
        return $tokenInfo;
    }
}
