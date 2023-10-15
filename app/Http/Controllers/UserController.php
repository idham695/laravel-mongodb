<?php

namespace App\Http\Controllers;

use JWTAuth;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public $token = true;

    public function register(Request $request)
    {

         $validator = Validator::make($request->all(), 
                      [ 
                      'name' => 'required',
                      'email' => 'required|email',
                      'password' => 'required',  
                      'c_password' => 'required|same:password', 
                     ]);  

         if ($validator->fails()) {  

            return response()->json(['code' => 400, 'error'=>$validator->errors()], 400); 

        }   


        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        if ($this->token) {
            return $this->login($request);
        }

        return response()->json([
            'code' => 201,
            'success' => true,
            'data' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $input = $request->only('email', 'password');
        $jwt_token = null;

        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json([
                'code' => 400,
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], 400);
        }

        return response()->json([
            'code' => 200,
            'success' => true,
            'token' => $jwt_token,
        ], 200);
    }

    public function refresh()
    {
        $token = JWTAuth::getToken();

        $token = JWTAuth::refresh($token);
        if(!$token){
            return response()->json([
                'code' => 400,
                'success' => false,
                'token' => $token,
            ], 400);
        }else {
            return response()->json([
                'code' => 200,
                'success' => true,
                'token' => $token,
            ], 200);
        }

    }

    public function logout(Request $request)
    {
        auth()->logout();

        return response()->json([
            'success' => true,
            'message' => 'User logged out successfully'
        ]);
        
    }
}