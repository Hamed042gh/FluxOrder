<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Exception;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            // Check if the email is already used
            $existingUser = User::where('email', $request->email)->first();
            if ($existingUser) {
                return response()->json([
                    'message' => 'Email already exists. Please use a different one.',
                ], 400);
            }

            // Create new user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Generate Token
            $token = $user->createToken('RegisterToken')->plainTextToken;

            // Return Json Response with success message and token in header
            return response()->json([
                'message' => 'User created successfully',
            ], 201)->withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ]);
        } catch (Exception $e) {
            // Handle unexpected errors
            return response()->json([
                'message' => 'An error occurred during registration',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function login(LoginRequest $request)
    {
        // Find the user by email
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid email or password. Please check your credentials.',
            ], 401);
        }

        // Generate Token
        $token = $user->createToken('LoginToken')->plainTextToken;

        // Return success message with token in header
        return response()->json([
            'message' => 'User logged in successfully',
        ], 200)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ]);
    }
}
