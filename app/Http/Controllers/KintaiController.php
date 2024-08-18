<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kintai;
use App\Http\Requests\KintaiRequest;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class KintaiController extends Controller
{
    public function __construct() {
       $this->middleware('auth');
    }

    public function show($userId) {
        if($userId != Auth::id()) {
            abort(404);
        }

        $now = Carbon::now();
        $startOfMonth = $now->startOfMonth()->toDateString();
        $endOfMonth = $now->endOfMonth()->toDateString();
        $period = CarbonPeriod::create($startOfMonth, $endOfMonth)->toArray();
        // 当月の月初から月末までを取得

        $month = $now->isoFormat('YYYY-MM');
        $kintais = Kintai::where('user_id', $userId)
                          ->where('this_month', 'like', "$month%")
                          ->get();

        foreach ($period as $day) {
            $days = $day->isoFormat('DD');
            $dateString = $day->toDateString();
            $columnName1 = 'work_start_' . $days;
            $columnName2 = 'work_end_' . $days;

            foreach ($kintais as $kintai) {
                $workStarts[$dateString] = isset($kintai->$columnName1) ?
                Carbon::parse($kintai->$columnName1)->format('H:i:s') : null;
                $workEnds[$dateString] = isset($kintai->$columnName2) ?
                Carbon::parse($kintai->$columnName2)->format('H:i:s') : null;
            }
        }

        return view('kintais.show',
            compact('now', 'period', 'workStarts', 'workEnds'));
    }

    public function create() {
        $month = Carbon::now()->isoFormat('YYYY-MM');
        $forMonth = Kintai::where('user_id', Auth::id())
                          ->where('this_month', 'like', "$month%")->get();
        $id = $forMonth->pluck('id')->first();

        if ($forMonth->isEmpty()) {
            return view('kintais.create');
        } else {
            return redirect()->route('edit.kintais', $id);
        }
    }

    public function store(KintaiRequest $request) {
        $userId = Auth::id();
        $today = Carbon::now()->format('d');
        $workStart = 'work_start_'. $today;

        $kintai = new Kintai();
        $kintai->user_id = $userId;
        $kintai->this_month = $request->this_month;
        $kintai->$workStart = Carbon::now();
        $kintai->save();

        return redirect()->route('show.kintais', $userId);
    }

    public function edit($id) {
        if($userId != Auth::id()) {
            abort(404);
        }
        $userId = Kintai::where('id', $id)->pluck('user_id')->first();
        $kintai = Kintai::findOrfail($id);
        $today = Carbon::now()->format('d');
        $workStart = 'work_start_' . $today;
        $workEnd = 'work_end_' . $today;

        return view('kintais.edit')->with([
            'kintai' => $kintai,
            'workStart' => $kintai->$workStart,
            'workEnd' => $kintai->$workEnd
        ]);
    }

    public function update(Request $request, $id) {
        $now = Carbon::now();
        $userId = Auth::id();
        $kintai = Kintai::findOrfail($id);
        $today = $now->format('d');
        $workStart = 'work_start_' . $today;
        $workEnd = 'work_end_' . $today;

        if ($request->has('work_start_') && !$kintai->$workStart) {
            $kintai->$workStart = $now;
            $kintai->save();
            return redirect()->route('show.kintais', $userId);
        } elseif ($request->has('work_end_') && !$kintai->$workEnd) {
            $kintai->$workEnd = $now;
            $kintai->save();
            return redirect()->route('show.kintais', $userId);
        } else {
            return redirect()->route('edit.kintais', $kintai->id)
                ->with('error', 'すでに打刻されています。');
        }
    }
}
