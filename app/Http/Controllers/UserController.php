<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('users.index')->with('users', $users) ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('register');
    }

     //show login form
     public function login()
     {
         
         return view('login');
       
     }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'phone' => ['required', 'max:10', Rule::unique('users', 'phone')],
            'role' => ['required'],
            'password' => 'required|confirmed|min:6',
        ]);

        // Hash Password
        $formFields['password'] = bcrypt($formFields['password']);

        // Create user
        $user = User::create($formFields);

        auth()->login($user);

        return redirect('/users')->with('message', 'User created and logged in');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

     //Logout user
     public function logout(Request $request)
     {
         auth()->logout();
 
         $request->session()->invalidate();
         $request->session()->regenerateToken();
         return view('login')->with('success', "You have been successfully logged out!");
     }
 

    //authenticate user
    public function authenticate(Request $request)
    {
        $formFields = $request->validate([
            'phone' => ['required'],
            'password' => 'required'
        ]);

        if (auth()->attempt($formFields)) {
            $request->session()->regenerate();

            return redirect('/users')->with('success', 'You are now logged in!');
        }
        return redirect('/')->with('success', 'Credentials dont match');


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(user $user)
    {
        if (Auth::guest()) {
            return redirect('login');
        }
        return view('users.edit', [
            'user' =>  $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, user $user)
    {
        $formFields = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'max:10'],
            'role' => ['required'],
        ]);

        if(isset($request['password'])){
            $formFields['password'] = bcrypt($request['password']);
        }

        // Update user
        $user->update($formFields);

        return redirect('/users')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
     // Delete User
     public function destroy(user $user)
     {
         $user->delete();
 
         return redirect('/users')->with('success', 'User deleted successfully!');
     }
    }
