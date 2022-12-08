<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PersonalToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use Nette\Utils\Json;

class AuthController extends Controller
{

    public function testPost(Request $request){
        dd($request->all());
    }
    public function register(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'first_name' => [ 'required','string', 'min:2', 'max:50'],
            'last_name' => [ 'required','string', 'min:2', 'max:50'],
            'username' => [ 'required','string', 'unique:users,username', 'min:5', 'max:10'],
            'email' => ['email', 'required', 'unique:users,email'],
            'password' => [ 'required','string','min:8', 'confirmed'],
        ]);
        if ($Validator->fails()) {
            return $this->failResponse($Validator->errors(),422);
        }
        $user = User::create(
            [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]
        );
        return $this->successResponse($user);
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
        $user = User::where('username', $request->username)->orWhere('email', $request->username)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                return $this->successResponse($user);
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
            'tokenable_type' => 'user',
            'tokenable_id' => $id,
            'token' => $hashToken
        ]);
        $tokenInfo['returnedToken'] = $token;
        return $tokenInfo;
    }

    private function successResponse($user)
    {
        $token = $this->generateToken($user->id);
        return response()->json([
            'message' => 'success',
            'user' => $user,
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
