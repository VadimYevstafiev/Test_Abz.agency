<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryContract;
use Illuminate\Http\Request;
//use Illuminate\Http\Request;
use Illuminate\View\View;

class UsersController extends Controller
{
    public function index(Request $request, UserRepositoryContract $repository): View
    {
        $users = $repository->get($request);

        return view('users/index', compact('users'));
    }
}
