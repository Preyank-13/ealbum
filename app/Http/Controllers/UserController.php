<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('user.pages.welcome');
    }
    public function about()
    {
        return view('user.pages.about');
    }
    public function contact()
    {
        return view('user.pages.contact');
    }
    public function price()
    {
        return view('user.pages.price');
    }
    public function blog()
    {
        return view('user.pages.blog');
    }
}
