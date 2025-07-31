<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Validation\ValidationException; 
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException; 

class AuthController extends Controller
{
    //

    /**
     * Handle user login
     * POST /api/register
     * Input: email, password
     * Output: 200 Verified, token returned
     */
    public function login(Request $request) {

        // Validation
        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Data was invalid',
                'errors' => $e->errors(),
            ], 422);
        }

        $credentials = $request->only('email', 'password');

        // Generate token
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'Could not create token'], 500);
        }

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
        ], 200); 
    }

    /**
     * Handle user registration
     * POST /api/register
     * Input: name, email, password
     * Output: 201 Created, token returned
     */
    public function register(Request $request) {
        // Validation
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8', 
            ]);
        } catch (ValidationException $e) {
            
            return response()->json([
                'message' => 'Data was invalid',
                'errors' => $e->errors(),
            ], 422);
        }

        // Create user
        $newUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password before saving [cite: 13]
        ]);

        
        $token = JWTAuth::fromUser($newUser);

        
        return response()->json([
            'message' => 'User registered successfully',
            'token' => $token,
        ], 201);
    }
}
