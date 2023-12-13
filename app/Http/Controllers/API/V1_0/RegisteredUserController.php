<?php

namespace App\Http\Controllers\API\V1_0;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Repositories\Contracts\UserRepositoryContract;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    public function __invoke(RegisterRequest $request, UserRepositoryContract $repository)
    {
        $user = $repository->create($request);

        event(new Registered($user));

        Auth::login($user);

        return response()->json([
            'status' => 'success',
            'data' => [
                "token" => Auth::user()->createToken('api')->plainTextToken
            ]
        ]);
    }
}
