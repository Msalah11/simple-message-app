<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
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
        if (! $token = auth()->attempt($credentials)) {
            // Sending error response if authentication fails
            return $this->sendError('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }

        // Sending success response with token if authentication succeeds
        return $this->sendSuccess($this->respondWithToken($token), __('User logged in successfully'));
    }

    // Method to format the token response
    private function respondWithToken($token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60 // Calculating token expiration time
        ];
    }
}
