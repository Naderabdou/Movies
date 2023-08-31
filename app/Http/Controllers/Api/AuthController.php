<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //login
    public function login(UserRequest $request)
    {

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)){
            $user = auth()->user();
            $data['user'] = new UserResource($user);
            $data['token'] = $user->createToken('my-app-token')->plainTextToken;
            return response()->api($data);
        }else{
            return response()->apiError( __('auth.failed'), 1, 401);
        }



    }

    //register
    public function register(UserRequest $request){


        $request->merge(['type' => 'user']);

        $user = User::create($request->all());
        $data['user'] = new UserResource($user);
        $data['token']= $user->createToken('my-app-token')->plainTextToken;
        return response()->api($data);
    }
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->api(null, __('auth.logout'), 0,200);
    }

    public function user(){

        $data['user'] = new UserResource(auth()->user('sanctum'));
        return response()->api($data);
    }
}
