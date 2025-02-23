<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use App\Notifications\NewUserRegistered;
use Illuminate\Support\Facades\Hash;
use Exception;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Register a new user",
     *     description="Register a new user by providing name, email, and password.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User created successfully")
     *         ),
     *         @OA\Header(
     *             header="Authorization",
     *             description="Bearer Token",
     *             @OA\Schema(type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Email already exists",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Email already exists. Please use a different one.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="An error occurred during registration")
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Login an existing user",
     *     description="Login an existing user by providing email and password.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User logged in successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User logged in successfully")
     *         ),
     *         @OA\Header(
     *             header="Authorization",
     *             description="Bearer Token",
     *             @OA\Schema(type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid email or password",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invalid email or password. Please check your credentials.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="An error occurred during login")
     *         )
     *     )
     * )
     */
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
