<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdminRequest;
use App\Http\Resources\Auth\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    /**
     * Logs Admin In
     * @param App\Http\Requests\Auth\AdminRequest
     * @param Illuminate\Http\Response
     */
    function login(AdminRequest $request)
    {
        
        $user = User::with('cart')->where("email", $request->email)->first();
        if(!Hash::check($request->validated()['password'], $user->password)){
            return response()->returnResult(status:"ok",message: "Wrong Credentials", data: null, response_code: Response::HTTP_FORBIDDEN);
        }
        auth()->guard()->attempt($request->validated());
        $token = $user->createToken("user")->plainTextToken;
        return response()->returnResult(status:"ok",message: "Logged in As: {$user->name}",
         data: [new UserResource($user), 'access_token' => $token],
          response_code: Response::HTTP_OK);
    }

     /**
     * Logs out Admin
     * @param App\Http\Requests\Auth\AdminRequest
     * @param Illuminate\Http\Response
     */
    function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->returnResult(message: "Logged Out Successfully");
    }
}
