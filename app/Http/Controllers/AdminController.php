<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Student;


class AdminController extends Controller
{
	public function dashboard() 
	{
		return view('admin.dashboard');
	}

	public function login(Request $request)
	{
		$request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::guard('admin')->attempt($credentials)) {
            
            return redirect()->route('admin.home');
        }

        return redirect()->route('admin.dashboard')->with('error', 'Oppes! You have entered invalid credentials');

	}

	public function home()
	{
		return view('admin.home');
	}

	public function logout()
	{
		Auth::guard('admin')->logout();
        return redirect('admin/dashboard');

	}
}
