<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Models\Admin;

use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function createAdmin(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string',
            'emailAddress' => 'required|email|unique:admins',
            'phoneNumber' => 'required|string|unique:admins',
            'password' => 'required|string|min:6',
        ]);

        $validatedData['password'] = bcrypt($request->password);

        $admin = Admin::create($validatedData);

        return response()->json(['admin' => $admin]);
    } 

    public function updateAdmin(Request $request, $id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return response()->json(['error' => 'admin not found'], 404);
        }

        // Validate and update only the fields that are actually changed
        if ($request->has('name')) {
            $admin->name = $request->input('name');
        }

        if ($request->has('emailAddress')) {
            $admin->emailAddress = $request->input('emailAddress');
        }

        if ($request->has('phoneNumber')) {
            $admin->phoneNumber = $request->input('phoneNumber');
        }

        if ($request->has('password')) {
            $admin->password = bcrypt($request->input('password'));
        }

        $admin->save();

        return response()->json(['admin' => $admin, 'success' => 1]);
    }

    public function index(){
        $admins  = Admin::all();
           $response["admins"] = $admins;
           $response["success"] = 1;
        return response()->json($response);
    }

}
