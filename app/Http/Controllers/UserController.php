<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
     }

    public function index($userId) {
        return view('users.index');
    }
}
