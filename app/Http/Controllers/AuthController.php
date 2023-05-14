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
        ]);

        return response()->json([
            'status' => 201,
            'message'=> 'Account registered successfully',
            'data' =>  new UserResource($user),
        ]);
    }

    public function login(FormLoginRequest $request) {
        $request->validated();
    
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('PAT')->accessToken;

            return response()->json([
                'status' => 201,
                'message' => 'Logged in successfully. Token will expire in 6 days',
                'Token' => $token
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message'=> 'Username or password incorrect',
            ]);
        }
    }

    public function logout(Request $request) {

        $request->user()->token()->revoke();

        return response()->json([
            'status' => 2001,
            'message'=> 'Account logout',
        ]);
    }
}
