<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminNotificationMail;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user) {
                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'token' => $token,
                    'is_admin' => $user->is_admin,
                    'message' => $user->is_admin ? 'Admin logged in successfully' : 'User logged in successfully'
                ], 200);
            } else {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => false,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $adminUser = User::where('is_admin', true)->first();
        if ($adminUser) {
            Mail::to($adminUser->email)->queue(new AdminNotificationMail($user));
        }

        return response()->json([
            'token' => $token,
            'is_admin' => $user->is_admin,
            'message' => 'User registered successfully'
        ], 201);
    }
}
