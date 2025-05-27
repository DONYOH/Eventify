<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Ramsey\Uuid\Lazy\compareTo;

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
        $Admin=User::find(Auth::user()->getAuthIdentifier());

        if ($Admin->role == 'client') {
            Auth::logout();
            return redirect()->route('login');
        }
        return redirect()->route('TableauBord');

    }
}
