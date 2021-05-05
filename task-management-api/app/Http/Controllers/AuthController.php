<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(UserStoreRequest $request): JsonResponse
    {
        $user = User::create([
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'email'         => $request->email,
            'password'      => bcrypt($request->password),
            'role'          => 2
        ]);

        $token = $user->createToken('TicketingAPI')->plainTextToken;

        $response = [
            'user'  => $user,
            'token' => $token
        ];

        return response()->json($response, 201);
    }

    public function login(UserLoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)
                ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'No user matches the credentials.'
            ], 401);
        }

        $token = $user->createToken($user->email)->plainTextToken;

        $response = [
            'user'  => $user,
            'token' => $token
        ];

        return response()->json($response, 201);
    }

    public function logout(): JsonResponse
    {
        User::find(Auth::id())->tokens()->delete();

        return response()->json([
            'message' => 'Logged out.'
        ]);
    }
}
