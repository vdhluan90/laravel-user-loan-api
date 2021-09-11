<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateAccessTokenRequest;
use App\Http\Requests\User\SignUpRequest;
use App\Http\Resources\User\AccessTokenResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends ApiController
{
    /**
     * @param SignUpRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signup(SignUpRequest $request)
    {
        $user = new User($request->all());
        $user->save();

        return $this->respondCreated();
    }

    /**
     * @param CreateAccessTokenRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(CreateAccessTokenRequest $request)
    {
        $credentials = request(['email', 'password']);

        if(!Auth::attempt($credentials)) {
            return $this->respondWithError('Invalid Credentials');
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();

        $user->access_token = $tokenResult->accessToken;
        $user->save();

        return $this->response(new AccessTokenResource($tokenResult));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return $this->response([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user(Request $request)
    {
        return $this->response(new UserResource($request->user()));
    }
}
