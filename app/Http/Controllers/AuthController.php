<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $data = $request->validate([
            'name' => 'string|required',
            'email' => 'email|required|unique:users',
            'password' => 'string|required|min:6',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $token = $user->createToken('apptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response);
    }

    public function login(Request $request){
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'string|required|min:6',
        ]);

        $user = User::where('email', $data['email'])->first();

        if(!$user || !Hash::check($data['password'], $user->password)){
            return response(['message' => 'Bad credentials']);
        }

        $token = $user->createToken('apptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response);
    }

    public function profile(){
        return response(auth()->user());
    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();
        return response(['message' => 'Your are logged out']);
    }
}
