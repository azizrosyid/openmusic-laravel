<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = bcrypt($validated['password']);
        $user = User::create($validated);
        return response()->json(["status" => "success", "message" => "User created successfully", "data" => ["userId" => $user->id]], 201);
    }

    /**
     * authenticate user
     *
     */

    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($validated)) {
            $token = auth()->user()->createToken('authToken')->plainTextToken;
            return response()->json([
                'message' => 'Login Successful',
                'status' => 'success',
                'data' => [
                    'accessToken' => $token,
                    'refreshToken' => $token,
                ],
            ], 201);
        }

        return response()->json([
            'message' => 'Login Failed',
            'status' => 'fail',
        ], 401);
    }

    /**
     * logout user
     *
     */
    public function logout()
    {
        $user = Auth::user();
        $user->tokens()->delete();

        return response()->json([
            'message' => 'Logout Successful',
            'status' => 'success',
        ], 200);
    }
}
