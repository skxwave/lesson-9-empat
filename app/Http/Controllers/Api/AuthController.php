<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Symfony\Component\VarDumper\Caster\RedisCaster;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request) {
        $emailValidation = User::where('email', $request->email)->exists();

        if ($emailValidation) {
            return response()->json([
                'success' => false,
                'error' => 'User already exists'
            ]);
        };

        $user = User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'email_verified_at' => now(),
            'password'=> bcrypt($request->password),
        ]);

        $token = $user->createToken('default')->plainTextToken;

        return response()->json([
            'success' => true,
            'data' => [
                'token' => $token
            ]
        ]);
    }

    public function login(LoginRequest $request) {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'data' => [
                    'error' => 'User not exists'
                ]
            ]);
        };

        $passwordValidation = Hash::check($request->password, $user->password);
        
        if (!$passwordValidation) {
            return response()->json([
                'success' => false,
                'data' => [
                    'error' => 'password incorrect'
                ]
            ]);
        };

        $token = $user->createToken('default')->plainTextToken;

        return response()->json([
            'success' => true,
            'data' => [
                'info' => 'login success',
                'token' => $token
            ]
        ]);
    }
}
