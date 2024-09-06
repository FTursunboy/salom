<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()->orderByDesc('created_at')->get();

        return view('admin.user.index', compact('users'));
    }
}
