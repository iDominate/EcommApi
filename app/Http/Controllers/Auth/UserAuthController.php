<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Http\Resources\Auth\UserResource;
use App\Models\User;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserAuthController extends Controller
{
    /**
     * Registers a user
     * 
     *  @param App\Http\Requests\UserRegisterRequest
     *  @return  Illuminate\Http\Response
     */
    public function register(UserRegisterRequest $request)
    {
        $user = User::create($request->validated());

        $token = $user->createToken('user')->plainTextToken;

        $data = [
            "user" => new UserResource($user),
            "token" => $token
        ];

        CartService::create(user_id: $user->id);
        
        return response()->returnResult(data: $data, response_code: Response::HTTP_CREATED);
    }

    /**
     * Logins User In
     * 
     * @param App\Http\Requests\UserLoginRequest
     * @return Illuminate\Http\Response
     */
    public function login(UserLoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if(!Hash::check($request->validated()['password'], $user->password))
        {
            return response()->returnResult(status: 'error', message: 'Wrong Credentials', response_code: Response::HTTP_FORBIDDEN);
        }

        $data = [
            'user' => new UserResource($user),
            'token' => $user->createToken('user')->plainTextToken
        ];
        return response()->returnResult(data: $data);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->returnResult();
    }
}