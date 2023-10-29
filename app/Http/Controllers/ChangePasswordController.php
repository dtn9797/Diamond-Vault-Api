<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

use App\Models\Admin;

class ChangePasswordController extends Controller
{
    public function changePassword(Request $request, $id)
    {
        //find the user
        $admin = Admin::find($id);
        if (!$admin) {
            return response()->json(['error' => 'Admin not found'], 404);
        }

        // Validate the old password
        if (!Auth::attempt(['emailAddress' => Auth::admin()->emailAddress, 'password' => $request->input('old_password')])) {
            return response()->json(['error' => 'Invalid old password'], 401);
        }

        // Update the password
        $admin->password = bcrypt($request->input('new_password'));
        $admin->save();

        return response()->json(['message' => 'Password changed successfully']);
    }
}

