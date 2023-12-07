<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;

interface UserRepositoryContract
{
    public function create(RegisterRequest $request): User|false;
}