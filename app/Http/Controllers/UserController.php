<?php

namespace App\Http\Controllers;

use App\Http\Resources\User\UserResource;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {

//        $users = User::whereNot('id', auth()->id())->get();
        $users = User::all();

        return UserResource::collection($users);
    }
}
