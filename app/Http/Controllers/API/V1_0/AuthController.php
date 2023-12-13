<?php

namespace App\Http\Controllers\API\V1_0;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        $request->authenticate();
        $user = Auth::user();

        if (!is_null($user->tokens()->first()))  $user->tokens()->delete();

        return response()->json([
            'status' => 'success',
            'data' => [
                "token" => $user->createToken('api')->plainTextToken
            ]
        ]);
    }
}
