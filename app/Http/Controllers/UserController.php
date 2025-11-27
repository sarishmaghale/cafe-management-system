<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LogInRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserCreateRequest;

class UserController extends Controller
{
    public function showLogInPage()
    {
        return view('login');
    }

    public function userLogin(LogInRequest $request)
    {
        $credentials = $request->validated();
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('stations.index');
        } else {
            return redirect()->route('LogInForm');
        }
    }

    public function userLogOut(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('stations.index');
    }

    public function index()
    {
        return view('create-user');
    }
    public function store(UserCreateRequest $request)
    {
        $validatedData = $request->validated();
        $user = User::create([
            'name' => $validatedData->name,
            'email' => $validatedData->email,
            'password' => bcrypt($validatedData->password),
        ]);
        $user->assignRole($validatedData->roles);
    }
}
