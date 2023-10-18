<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function show()
    {
        $user_id = auth()->user()->id;
        $year_month = date('Y-m');

        $attendance = Attendance::where('user_id', $user_id)
            ->where('year_month', $year_month)
            ->first();

        return view('record', compact('attendance'));
    }

    public function beginWork(Request $request)
    {
        $user_id = auth()->user()->id;
        $year_month = date('Y-m');
        $current_time = now();

        $attendance = Attendance::where('user_id', $user_id)
            ->where('year_month', $year_month)
            ->first();

        $day = $current_time->format('j');
        $column_name = 'day'.$day.'_begin';
        $attendance->$column_name = $current_time;
        $attendance->save();

        return redirect()->back();
    }
}
