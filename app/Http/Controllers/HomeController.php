<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kintai;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

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
        $kintais = Kintai::latest()->get();
        // $periods = [];
        // $date = null;
        // $workStarts = [];
        // $workEnds = [];
        // $breakStarts = [];
        // $breakEnds = [];

        if ($kintais->isNotEmpty()) {
            // 1ヶ月の配列を作成
            $kintai = $kintais->first();
            $date = $kintai->date;
            $year = substr($date, 0, 4);
            $month = substr($date, 5, 2);
            $carbon = Carbon::createFromDate($year, $month, 1);
            // 月初を取得
            $startOfMonth = $carbon->startOfMonth()->toDateString();
            // 月末を取得
            $endOfMonth = $carbon->endOfMonth()->toDateString();
            // 月初～月末の期間を取得
            $period = CarbonPeriod::create($startOfMonth, $endOfMonth)->toArray();
            $periods[] = $period;

            // 各日のデータを取得
            foreach ($period as $day) {
                $dayString = $day->toDateString(); // 日付を文字列に変換
                $dayNumber = (int)substr($dayString, 8, 2);
                $columnName = 'work_start_' . str_pad($dayNumber, 2, '0', STR_PAD_LEFT);
                $workStarts[$dayString] = $kintai->$columnName;
            }
            foreach ($period as $day) {
                $dayString = $day->toDateString();
                $dayNumber = (int)substr($dayString, 8, 2);
                $columnName = 'work_end___' . str_pad($dayNumber, 2, '0', STR_PAD_LEFT);
                $workEnds[$dayString] = $kintai->$columnName;
            }
            foreach ($period as $day) {
                $dayString = $day->toDateString();
                $dayNumber = (int)substr($dayString, 8, 2);
                $columnName = 'break_start' . str_pad($dayNumber, 2, '0', STR_PAD_LEFT);
                $breakStarts[$dayString] = $kintai->$columnName;
            }
            foreach ($period as $day) {
                $dayString = $day->toDateString();
                $dayNumber = (int)substr($dayString, 8, 2);
                $columnName = 'break_end__' . str_pad($dayNumber, 2, '0', STR_PAD_LEFT);
                $breakEnds[$dayString] = $kintai->$columnName;
            }
        }

        return view('home')
            ->with(['kintais' => $kintais, 'periods' => $periods, 'date' => $date, 'month' => $month, 'workStarts' => $workStarts, 'workEnds' => $workEnds, 'breakStarts' => $breakStarts, 'breakEnds' => $breakEnds]);
    }


}
