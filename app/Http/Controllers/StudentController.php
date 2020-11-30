<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;


class StudentController extends Controller
{
    public function welcome() 
	{
		return view('home');
	}
}
