<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryContract
{
    public function create(RegisterRequest $request): User|false;

    public function getAll(Request $request): LengthAwarePaginator;

    public function getUser(Request $request): User;
}