<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required',
            'address' => 'required',
            'phone' => 'required'
        ]);

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'phone' => $request->phone,
            'role' => "user"
        ]);

        return response()->json([
            'message' => 'Registration Successfull'
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('username', 'password'))) {
            throw ValidationException::withMessages([
                'username' => ['Username tidak ditemukan.'],
            ]);
        }

        $user = User::where('username', $request->username)->first();

        return response()->json([
            'message' => 'Login successful',
            'access_token' => $user->createToken('auth_token')->plainTextToken,
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
