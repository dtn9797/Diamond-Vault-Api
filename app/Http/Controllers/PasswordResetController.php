<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function createToken(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return response()->json(['message' => 'Email not found'], 404);
        }

        // Generate a unique token and store it in the password_reset_tokens table
        $token = Str::random(60);
        PasswordResetToken::updateOrCreate(
            ['email' => $user->email],
            ['token' => $token]
        );

        // Send the reset link with the token to the user's email
        // You would typically send an email with a link containing the token for the user to reset their password.

        return response()->json(['message' => 'Reset token created and sent to the user']);
    }

    public function resetPassword(Request $request, $token)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $resetToken = PasswordResetToken::where('token', $token)->first();

        if (!$resetToken) {
            return response()->json(['message' => 'Invalid or expired token'], 404);
        }

        // Find the user associated with the token
        $user = User::where('email', $resetToken->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Update the user's password and delete the token
        $user->password = Hash::make($request->input('password'));
        $user->save();

        $resetToken->delete();

        return response()->json(['message' => 'Password reset successfully']);
    }
}
