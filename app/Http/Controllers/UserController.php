<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use App\Models\User;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function createUser(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData);

        return response()->json(['user' => $user]);
    } 

    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Validate and update only the fields that are actually changed
        if ($request->has('name')) {
            $user->name = $request->input('name');
        }

        if ($request->has('email')) {
            $user->email = $request->input('email');
        }

        if ($request->has('phone_number')) {
            $user->phone_number = $request->input('phone_number');
        }

        if ($request->has('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        return response()->json(['user' => $user, 'success' => 1]);
    }

    public function index(){
        $users  = User::all();
           $response["users"] = $users;
           $response["success"] = 1;
        return response()->json($response);
    }

}
