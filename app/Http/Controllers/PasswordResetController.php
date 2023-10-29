<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\PasswordResetToken;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function createToken(Request $request)
    {
        $request->validate(['emailAddress' => 'required|emailAddress']);

        $admin = Admin::where('emailAddress', $request->input('emailAddress'))->first();

        if (!$admin) {
            return response()->json(['message' => 'Email not found'], 404);
        }

        // Generate a unique token and store it in the password_reset_tokens table
        $token = Str::random(60);
        PasswordResetToken::updateOrCreate(
            ['emailAddress' => $admin->emailAddress],
            ['token' => $token]
        );

        // Send the reset link with the token to the user's email
        // You would typically send an email with a link containing the token for the user to reset their password.

        return response()->json(['message' => 'Reset token created and sent to the admin']);
    }

    public function resetPassword(Request $request, $token)
{
    $request->validate([
        'password' => 'required|string|min:6|confirmed',
    ]);

    // Verify if the user is authenticated using the provided token
    if (!auth('api')->check()) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $resetToken = PasswordResetToken::where('token', $token)->first();

    if (!$resetToken) {
        return response()->json(['message' => 'Invalid or expired token'], 404);
    }

    // Find the user associated with the token
    $admin = Admin::where('emailAddress', $resetToken->emailAddress)->first();

    if (!$admin) {
        return response()->json(['message' => 'Admin not found'], 404);
    }

    // Update the user's password and delete the token
    $admin->password = Hash::make($request->input('password'));
    $admin->save();

    $resetToken->delete();

    return response()->json(['message' => 'Password reset successfully']);
}


}
