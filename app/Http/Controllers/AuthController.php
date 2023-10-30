<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Models\Admin;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;


class AuthController extends Controller{

    public function register(Request $request)
{
    $validator = \Validator::make($request->all(),[
        'name' => 'required|string',
        'emailAddress' => 'required|email|unique:admins',
        'phoneNumber' => 'required|string|unique:admins',
        'password' => 'required|string|min:6',
    ]);

    if ($validator->fails()) {
        return new JsonResponse(['errors' => $validator->errors()], 422);
    }

    // Validate the request data again
    $validatedData = $request->validate([
        'name' => 'required|string',
        'emailAddress' => 'required|email|unique:admins',
        'phoneNumber' => 'required|string|unique:admins',
        'password' => 'required|string|min:6',
    ]);
    $validatedData['password'] = bcrypt($request->password);

    $admin = Admin::create($validatedData);

    // Generate an authentication token for the registered user.
    $token = $admin->createToken('MyAppToken')->plainTextToken;

    return response()->json(['admin' => $admin, 'token' => $token],201);
}

public function login(Request $request)
{
    $validatedData = $request->validate([
        
        'emailAddress' => 'required|string',
        
        'password' => 'required|string',
    ]);

    //Check email
    $admin = Admin::where('emailAddress',$validatedData['emailAddress'])->first();

    // Check password
    if(!$admin || !Hash::check($validatedData['password'], $admin->password)) {
        return response([
            'message' => 'Bad creds'
        ], 401);
    }

    $token = $admin->createToken('MyAppToken')->plainTextToken;

    $response = [
        'admin' => $admin,
        'token' => $token
    ];

    return response($response, 201);
}

public function logout(Request $request){
    auth()->user()->tokens()->delete();
    return[
        'message' => 'Logged out'
    ];
}

public function updateAdmin(Request $request, $id)
{
    $admin = Admin::find($id);
    
    if (!$admin) {
        return response()->json(['error' => 'Admin not found'], 404);
    }

    // Validate and update only the fields that are actually changed
    if ($request->has('name')) {
        $admin->name = $request->input('name');
    }

    if ($request->has('emailAddress')) {
        $admin->emailAddress = $request->input('emailAddress');
    }

    if ($request->has('phone_number')) { // Adjust the field name to match your request
        $admin->phone_number = $request->input('phone_number');
    }

    if ($request->has('password')) {
        $admin->password = bcrypt($request->input('password'));
    }

    $admin->save();

    return response()->json(['admin' => $admin, 'success' => 1]);
}

public function index()
{
    $admins = Admin::all();
    $response["admins"] = $admins;
    $response["success"] = 1;
    
    return response()->json($response);
}


}

