<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Register a new user and create token
     *
     * @param  App\Http\Requests\UserStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function register(UserStoreRequest $request) {
        $user = User::create([
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'email'         => $request->email,
            'password'      => bcrypt($request->password)
        ]);

        $token = $user->createToken('TicketingAPI')->plainTextToken;

        $response = [
            'user'  => $user,
            'token' => $token
        ];

        return response()->json($response, 201);
    }

    /**
     * Login user and create token
     *
     * @param  App\Http\Requests\UserLoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function login(UserLoginRequest $request) {
        $user = User::where('email', $request->email)
                ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'No user matches the credentials.'
            ], 401);
        }

        $token = $user->createToken('TicketingAPI')->plainTextToken;

        $response = [
            'user'  => $user,
            'token' => $token
        ];

        return response()->json($response, 201);
    }
    
    /**
     * Logout user and delete saved token
     *
     * @return \Illuminate\Http\Response
     */
    public function logout() {
        User::find(Auth::id())->tokens()->delete();

        return response()->json([
            'message' => 'Logged out.'
        ]);
    }
}
