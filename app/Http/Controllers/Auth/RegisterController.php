<?php

namespace App\Http\Controllers\Auth;

use App\Student;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
        'fname' => 'required|string|max:255',
        'lname' => 'required|string|max:255',
        'mname' => 'required|string|max:255',
        'mobile' => 'required|numeric|digits:10',
        'gender' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:students',
        'password' => 'required|string|min:8|confirmed',
        'password_confirmation' => 'required',
        'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg'
        ]);

        $profilePhoto = '';
        if($files = $request->file('photo'))
        {
            $destinationPath = 'photo/';
            $profilePhoto = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $profilePhoto);
        }

        Student::create([
          'first_name' => $request->fname,
          'last_name' => $request->lname,
          'middle_name' => $request->mname,
          'gender' => $request->gender,
          'email' => $request->email,
          'mobile' => $request->mobile,
          'password' => Hash::make($request->password),
          'image' => $profilePhoto,
        ]);

        return redirect()->route('dashboard')->with('message', 'You are successfully registered');
    }

    
    
}
