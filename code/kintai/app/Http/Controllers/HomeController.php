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

        $day = $current_time->format('j');
        $column_name = 'day'.$day.'_begin';

        if ($attendance->$column_name === null) {
            $status = 'before_work';
        } else {
            $status = 'during_work';
        }

        return view('home', ['status' => $status]);
    }
}
