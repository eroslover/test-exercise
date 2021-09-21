<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginFormRequest;
use App\Http\Requests\Api\Auth\RegisterFormRequest;
use App\Models\User;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\Auth;

/**
 * Class AuthController
 *
 * @package App\Http\Controllers\Api
 */
class AuthController extends Controller
{
    /**
     * @var \Illuminate\Routing\ResponseFactory
     */
    private ResponseFactory $response;

    /**
     * AuthController constructor.
     *
     * @param \Illuminate\Routing\ResponseFactory $response
     */
    public function __construct(ResponseFactory $response)
    {
        $this->response = $response;
    }

    /**
     * @param \App\Http\Requests\Api\Auth\RegisterFormRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterFormRequest $request)
    {
        User::query()->create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password'))
        ]);

        return $this->response->json([
            'message' => 'You were successfully registered. Now you can sign in use your credentials.',
            'status' => true,
        ]);
    }

    /**
     * @param \App\Http\Requests\Api\Auth\LoginFormRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginFormRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->get('remember'))) {
            $accessToken = Auth::user()->createToken('Personal Access Token');

            return $this->response->json([
                'token_type' => 'Bearer',
                'access_token' => $accessToken->plainTextToken,
                'status' => true,
            ]);
        }

        return $this->response->json([
            'errors' => 'Incorrect credentials.',
            'status' => false,
        ], 401);
    }
}
