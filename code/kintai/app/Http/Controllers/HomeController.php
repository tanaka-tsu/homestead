<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;

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
        $user_id = auth()->user()->id;
        $year_month = date('Y-m');
        $current_time = now();

        $attendance = Attendance::where('user_id', $user_id)
            ->where('year_month', $year_month)
            ->first();

        if (!$attendance) {
            $attendance = new Attendance();
            $attendance->user_id = $user_id;
            $attendance->year_month = $year_month;
            $attendance->save();
        }

        $day = $current_time->format('j');
        $begin_column = 'day'.$day.'_begin';
        $finish_column = 'day'.$day.'_finish';

        if ($attendance->$begin_column === null) {
            $status = 'before_work';
        } else if ($attendance->$finish_column === null) {
            $status = 'during_work';
        } else {
            $status = 'after_work';
        }

        return view('home', ['status' => $status]);
    }
}
