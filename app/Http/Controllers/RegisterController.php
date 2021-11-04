<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function create() {
        return view('register.create');
    }

    public function store() {
        // create the user
//        dd(request()->request);

        $attributes = request()->validate([
            'name' => ['required', 'max:255', 'min:3'],
            'username' => ['required','min:3','max:255', Rule::unique('users', 'username')],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'max:255', 'min:8'],
//            'name' => 'required|max:255|min:3',
//            'username' => 'required|max:255|min:3|unique:users,username',
//            'email' => 'required|email|max:255|unique:users,email',
//            'password' => 'required|max:255|min:8',
        ]);

        // NB Model mutator handles password encryption
        $user = User::create($attributes);

        // log the new user in
        auth()->login($user);

//        session()->flash('success', 'Account created');

        return redirect('/')->with('success', 'Account created');
    }
}
