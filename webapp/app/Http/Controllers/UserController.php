<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 

class UserController extends Controller
{
    public function edit()
    {
        $users = User::all();  
        return view('profile.edit', compact('users'));
    }

    public function create()
    {
        $users = User::all();  
        return view('tasks.create', compact('users'));
    }
}
