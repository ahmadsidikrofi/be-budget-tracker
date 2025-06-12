<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function RegisterUser( Request $request )
    {
        $valid = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:7'
        ], [
            'name.required' => 'Your name is required',
            'email.required' => 'Your email is required',
            // 'email.unique' => 'email is exist, try another one',
            'password.required' => 'Password is required'
        ]);
        if ($valid->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'There seems to be an error in inputting user data',
                $valid->errors()
            ], 422);
        }

        $checkEmail = User::where('email', $request->email)->first();
        if ($checkEmail) {
            return response()->json([
                'success' => false,
                'message' => 'This email is already registered',
            ], 409);
        }

        try {
            $newUser = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->password)
            ]);
            $token = $newUser->createToken('auth_token')->plainTextToken;
            if ($newUser) {
                return response()->json([
                    'success' => true,
                    'message' => 'User has been successfully registered',
                    'patient' => $newUser,
                    'access_token' => $token,
                    'token_type' => 'bearer'
                ], 201);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed',
                'error' => 'You have no right to know. Let the backend handle it',
                'if you insist' => $e
            ], 500);
        }
    }

    public function LoginUser( Request $request )
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => 'No user with email or password like this'
            ], 401);
        }
        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        if ($token) {
            return response()->json([
                'success' => true,
                'message' => 'You are logged in',
                'access_token' => $token,
                'token_type' => 'bearer'
            ], 200);
        }
    }

    public function LogoutUser()
    {
        if (Auth::check()) {
            Auth::user()->tokens()->delete();
            return response()->json([
                'success' => true,
                'message' => 'Successfully Logout. Dont forget to come back',
            ], 200);
        }
    }
}
