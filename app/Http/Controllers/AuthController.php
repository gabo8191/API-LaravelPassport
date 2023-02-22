<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required'
        ]);

        $validatedData['password'] = bcrypt($request->password);
        $user = User::create($validatedData);
        // $client = DB::table('oauth_clients')->insert([
        //     'user_id' => $user->id,
        //     'name' => $user->name,
        //     'secret' => $user->password,
        //     'redirect' => 'http://localhost:8000',
        //     'personal_access_client' => 0,
        //     'password_client' => 1,
        //     'revoked' => 0,
        // ]);
        // $accessToken = $user->createToken('authToken')->accessToken;
        return response([
            'user' => $user,
            // 'client' => $client,
            // 'access_token' => $accessToken,
            'message' => 'User created successfully',
            'token_type' => 'Bearer'
        ], 201);
    }

    public function login(Request $request)
    { {
            $loginData = $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);

            if (!auth()->attempt($loginData)) {
                return response([
                    'message' => 'Invalid credentials'
                ], 401);
            }
            $user = $request->user();

            $tokenResult = $user->createToken('authToken');
            $token = $tokenResult->token;
            $token->save();

            return response([
                'user' => auth()->user(),
                'access_token' => $tokenResult->accessToken,
                'message' => 'User logged in successfully',
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ], 201);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response([
            'message' => 'User logged out successfully',
        ], 200);
    }

    
}
