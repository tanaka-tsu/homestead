<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
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
        $authUserId = Auth::id();
        if($userId != $authUserId) {
            abort(404);
        } else {
            // 当月の月初から月末までを取得
            $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
            $endOfMonth = Carbon::now()->endOfMonth()->toDateString();
            $period = CarbonPeriod::create($startOfMonth, $endOfMonth)->toArray();

            $kintais = Auth::user()->kintais;
            $workStarts = [];
            $workEnds = [];
            $breakStarts = [];
            $breakEnds = [];

            foreach ($period as $day) {
                $days = $day->isoFormat('DD');
                $columnName1 = 'work_start_' . $days;
                $columnName2 = 'work_end_' . $days;
                $columnName3 = 'break_start_' . $days;
                $columnName4 = 'break_end_' . $days;

                foreach ($kintais as $kintai) {
                    if (isset($kintai->$columnName1)) {
                        $workStarts[$day->toDateString()] = $kintai->$columnName1;
                        break;
                    } else {
                        $workStarts[$day->toDateString()] = null; // データがない場合はnullを設定
                    }
                    if (isset($kintai->$columnName2)) {
                        $workEnds[$day->toDateString()] = $kintai->$columnName2;
                        break;
                    } else {
                        $workEnds[$day->toDateString()] = null;
                    }
                    if (isset($kintai->$columnName3)) {
                        $breakStarts[$day->toDateString()] = $kintai->$columnName3;
                        break;
                    } else {
                        $breakStarts[$day->toDateString()] = null;
                    }
                    if (isset($kintai->$columnName4)) {
                        $breakEnds[$day->toDateString()] = $kintai->$columnName4;
                        break;
                    } else {
                        $breakEnds[$day->toDateString()] = null;
                    }
                }
            }

            return view('kintais.show')
                ->with([
                    'kintais' => $kintais,
                    'user_id' => $userId,
                    'period' => $period,
                    'workStarts' => $workStarts,
                    'workEnds' => $workEnds,
                    'breakStarts' => $breakStarts,
                    'breakEnds' => $breakEnds,
                ]);
        }
    }

    public function create() {
        return view('kintais.create');
    }

    public function store(KintaiRequest $request) {
        $user = Auth::user();
        $userId = $user->id;
        $thisMonth = $request->this_month;
        $today = Carbon::now()->format('d');
        $workStart = 'work_start_' . $today;

        $kintai = new Kintai();
        $kintai->user_id = $userId;
        $kintai->this_month = $thisMonth;
        $kintai->$workStart = Carbon::now();
        $kintai->save();

        return redirect()->route('edit.kintais', $kintai->id);
    }

    public function edit($id) {
        $kintai = Kintai::findOrfail($id);

        return view('kintais.edit')->with('kintai', $kintai);
    }

    public function update(KintaiRequest $request, $id) {
        $kintai = Kintai::findOrfail($id);
        $today = Carbon::now()->format('d');
        $workStart = 'work_start_' . $today;
        $workEnd = 'work_end_' . $today;
        $breakStart = 'break_start_' . $today;
        $breakEnd = 'break_end_' . $today;

        if ($request->has('work_start_')) {
            $kintai->$workStart = Carbon::now();
        } elseif ($request->has('work_end_')) {
            $kintai->$workEnd = Carbon::now();
        } elseif ($request->has('break_start_')) {
            $kintai->$breakStart = Carbon::now();
        } elseif ($request->has('break_end_')) {
            $kintai->$breakEnd = Carbon::now();
        }

        $kintai->save();

        return redirect()->route('edit.kintais', $kintai->id);
    }
}
