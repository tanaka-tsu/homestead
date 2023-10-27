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
        $begin_column = 'day'.$day.'_begin';
        $attendance->$begin_column = $current_time->format('H:i');
        $attendance->save();

        return redirect()->back();
    }

    public function finishWork(Request $request)
    {
        $user_id = auth()->user()->id;
        $year_month = date('Y-m');
        $current_time = now();

        $attendance = Attendance::where('user_id', $user_id)
            ->where('year_month', $year_month)
            ->first();

        $day = $current_time->format('j');
        $finish_column = 'day'.$day.'_finish';
        $break_column = 'day'.$day.'_break';

        $attendance->$finish_column = $current_time->format('H:i');
        $attendance->$break_column = $request->input('break_time');
        $attendance->save();

        return redirect()->back();
    }
}
