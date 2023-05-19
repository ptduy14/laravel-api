<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Http\Requests\FormLoginRequest;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(CreateUserRequest $request) {
        $request->validated();

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'gender' => $request->input('gender'),
            'password' => bcrypt($request->input('password')),
        ])->assignRole('user');

        return response()->json([
            'status' => 201,
            'message'=> 'Account registered successfully',
            'data' =>  new UserResource($user),
        ]);
    }

    public function login(FormLoginRequest $request) {
        $request->validated();
    
        $credentials = request(['email', 'password']);

        
        if (! $token = auth()->guard('jwt')->attempt($credentials)) {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized'
            ]);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function profile($id) {
        $user_id = auth('jwt')->user()->user_id;

        if ($user_id !== (int)$id ) {
            return response()->json([
                'status' => 401 ,
                'message' => 'Access Denied',
            ]);
        }
        
        $user = User::find($id);

        return response()->json([
            'status' => 201,
            'message'=> 'Account registered successfully',
            'data' =>  new UserResource($user),
        ]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'status' => 200,
            'message' => 'login succesfully',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->guard('jwt')->factory()->getTTL() * 60
        ]);
    }
}
