<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    // app/Http/Controllers/HomeController.php (or AdminController)
public function dashboard()
{
    $userId = auth()->id();
    $todos = \App\Models\Todo::where('user_id', $userId)->latest()->get();
    return view('dashboard', compact('todos'));
}

}
