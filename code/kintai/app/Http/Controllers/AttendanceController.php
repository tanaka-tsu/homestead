<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function show()
    {
        $attendance = Attendance::where('id', 1)->first();
        return view('record', compact('attendance'));
    }
}
