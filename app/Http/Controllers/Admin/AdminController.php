<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\Admin;

class AdminController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function index() {
        $id = Auth::guard('admin')->user()->id;
        $admin = Admin::findOrFail($id);
        if ($id != Auth::id()) { abort(404); }

        return view('admin.index', compact('id', 'admin'));
    }
}
