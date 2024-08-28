<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Location;
use App\Models\Condition;
use App\Models\Admin;

class OptionController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function store(Request $request) {
        $admin_id = Auth::id();
        $request->validate([
            'office_name' => 'nullable|string|max:255',
            'detail' => 'nullable|string|max:255',
        ]);

        if ($request->filled('office_name')) {
            Location::create(['office_name' => $request->office_name]);
        }
        if ($request->filled('detail')) {
            Condition::create(['detail' => $request->detail]);
        }

        return redirect()->route('admin.show', $admin_id);
    }

    public function locationDestroy($id) {
        $admin_id = Auth::id();
        $location = Location::findOrfail($id);
        $location->delete();

        return redirect()->route('admin.show', $admin_id);
    }

    public function conditionDestroy($id) {
        $admin_id = Auth::id();
        $condition = Condition::findOrfail($id);
        $condition->delete();

        return redirect()->route('admin.show', $admin_id);
    }

    protected function options() {
        $locations = Location::all();
        $conditions = Condition::all();

        return view('auth.register', compact('locations', 'conditions'));
    }
}
