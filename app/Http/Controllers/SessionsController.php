<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;

class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

//        $encrypted = bcrypt($attributes['password']);
//        ddd($attributes, $encrypted);

        if (! auth()->attempt($attributes)) {
            throw ValidationException::withMessages([
                'email' => 'The credentials provided were not verified.'
            ]);
        }

        session()->regenerate();

        return redirect('/')->with('success', 'Logged in');
    }

    public function destroy()
    {
        auth()->logout();

        return redirect('/')->with('success', 'Logged out');
    }
}
