<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Models\Admin;

use Illuminate\Support\Facades\Hash;

class AuthController extends Controller{

    public function register(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string',
        'emailAddress' => 'required|email|unique:users',
        'phone_number' => 'required|string|unique:users',
        'password' => 'required|string|min:6',
    ]);

    $validatedData['password'] = bcrypt($request->password);

    $admin = Admin::create($validatedData);

    // Generate an authentication token for the registered user.
    $token = $admin->createToken('MyAppToken')->accessToken;

    return response()->json(['admin' => $admin, 'token' => $token]);
}

public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (auth()->attempt($credentials)) {
        $admin = auth()->user();
        $token = $admin->createToken('MyAppToken')->accessToken;

        return response()->json(['admin' => $admin, 'token' => $token]);
    }

    return response()->json(['error' => 'Unauthorized'], 401);
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

