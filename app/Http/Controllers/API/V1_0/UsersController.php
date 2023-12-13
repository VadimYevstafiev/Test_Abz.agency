<?php

namespace App\Http\Controllers\API\V1_0;

use App\Http\Controllers\Controller;
use App\Http\Resources\Users\UsersCollection;
use App\Http\Resources\Users\UsersResource;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryContract;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request, UserRepositoryContract $repository)
    {
        $users = $repository->getAll($request);

        return new UsersCollection($users);
    }

    public function show(Request $request, UserRepositoryContract $repository)
    {
        $user = $repository->getUser($request);

        return new UsersResource($user);
    }
}
