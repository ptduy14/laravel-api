<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Exceptions\ItemDoesNotExit;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function getAllUsers() {
        $users = User::all();

        throw_if(!$users, ItemDoesNotExit::class);

        return response()->json([
            'status' => 200,
            'message' => 'The action is done successfully',
            'data' => UserResource::collection($users),
        ]);
    }

    public function getUser($id) {
        $user = User::find($id);

        throw_if(!$user, ItemDoesNotExit::class);

        return response()->json([
            'status' => 200,
            'message' => 'The action is done successfully',
            'data' => new UserResource($user),
        ]);
    }

    public function createUser(CreateUserRequest $request) {
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
            'message'=> 'The item was created successfully',
            'data' =>  new UserResource($user),
        ]);
    }

    public function updateUser(UpdateUserRequest $request,$id) {
        $user = User::find($id);

        throw_if(!$user, ItemDoesNotExit::class);

        $request->validated();

        $user->update([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'gender' => $request->input('gender'),
        ]);
        
        return response()->json([
            'status' => 200,
            'message' => 'The action is done successfully',
            'data' => new UserResource($user),
        ]);
    }

    public function deleteUser($id) {
        $user = User::find($id);

        throw_if(!$user, ItemDoesNotExit::class);

        $user->delete();

        return response()->json([
            'status' => 204,
            'message' => 'The action is done successfully',
        ]);
    }
}
