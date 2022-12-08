<?php

namespace App\Http\Controllers\Orgnaiztion\Auth;

use App\Http\Controllers\Controller;
use App\Models\Orgnaization;
use App\Models\PersonalToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthOrgController extends Controller
{
    public function register(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'name' => [ 'required','string', 'min:2', 'max:50', 'unique:orgnaizations,name'],
            'username' => [ 'required','string', 'unique:orgnaizations,username', 'min:5', 'max:10'],
            'email' => ['email', 'required', 'unique:orgnaizations,email'],
            'password' => [ 'required','string','min:8', 'confirmed'],
            'phone' => ['required', 'numeric', 'unique:orgnaizations,phone']
        ]);
        if ($Validator->fails()) {
            return $this->failResponse($Validator->errors(),422);
        }
        $orgnaization = Orgnaization::create(
            [
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
            ]
        );
        return $this->successResponse($orgnaization);
    }

    public function login(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'username' => ['required','string'],
            'password' => ['required','string'],
        ]);
        if ($Validator->fails()) {
            return $this->failResponse($Validator->errors(),422);
        }
        $orgnaization = Orgnaization::where('username', $request->username)->orWhere('email', $request->username)->first();
        if ($orgnaization) {
            if (Hash::check($request->password, $orgnaization->password)) {
                return $this->successResponse($orgnaization);
            } else {
                return $this->failResponse(['password' => ['Invalid password']], 422);
            }
        } else {
            return $this->failResponse(['username' => ['Invalid username or email']], 422);
        }
    }

    public function logout(Request $request){
        $token = PersonalToken::findOrFail($request->token['id']);
        $token->delete();
        return response()->json([
            'status' => true,
            'message' => 'Logout successful',
        ]);
    }


    protected function generateToken($id)
    {
        $token = fake()->uuid();
        $hashToken = Hash::make($token);
        $tokenInfo = PersonalToken::create([
            'tokenable_type' => 'orgnaization',
            'tokenable_id' => $id,
            'token' => $hashToken
        ]);
        $tokenInfo['returnedToken'] = $token;
        return $tokenInfo;
    }

    private function successResponse($orgnaization)
    {
        $token = $this->generateToken($orgnaization->id);
        return response()->json([
            'message' => 'success',
            'orgnaization' => $orgnaization,
            'token' => $token,
            'code' => 200
        ]);
    }
    private function failResponse($message, $errorCode)
    {
        return response()->json([
            'message' => $message,
            'code' => $errorCode
        ]);
    }
}
