<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use App\Http\Resources\UserResource;
use App\Traits\ApiResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    use ApiResponse; // Importing the ApiResponse trait

    // Method to handle user login
    public function login(AuthRequest $request)
    {
        // Extracting phone and password from the request
        $credentials = $request->only('phone', 'password');

        // Attempting authentication with provided credentials
        if (! $token = auth('api')->attempt($credentials)) {
            // Sending error response if authentication fails
            return $this->sendError(__('Unauthorized access. Please provide valid credentials.'), Response::HTTP_UNAUTHORIZED);
        }

        // Sending success response with token if authentication succeeds
        return $this->sendSuccess($this->respondWithToken($token), __('User logged in successfully'));
    }

    // Method to format the token response
    private function respondWithToken($token): array
    {
        return [
            'token' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => config('jwt.ttl') * 60
            ],
            'user' => new UserResource(auth('api')->user())
        ];
    }
}
