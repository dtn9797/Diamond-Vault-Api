<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use DB;

use App\Models\User;

class ChangePasswordController extends Controller
{
    public function changePassword(Request $request, $id)
    {
        //find the user
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Validate the old password
        if (!Auth::attempt(['email' => Auth::user()->email, 'password' => $request->input('old_password')])) {
            return response()->json(['error' => 'Invalid old password'], 401);
        }

        // Update the password
        $user->password = bcrypt($request->input('new_password'));
        $user->save();

        return response()->json(['message' => 'Password changed successfully']);
    }
}

