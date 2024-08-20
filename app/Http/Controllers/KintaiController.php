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

    private function getUserIdOrFail($kintai) {
        if ($kintai->user_id != Auth::id()) { abort(404); }
    }

    private function kintaiForMonth($userId) {
        $month = Carbon::now()->format('Y-m');
        $kintais = Kintai::where('user_id', $userId)
                          ->where('this_month', 'like', "$month%")
                          ->get();
        $id = $kintais->pluck('id')->first();

        return (object) [
            'kintais' => $kintais,
            'id' => $id
        ];
    }

    private function getMonthly() {
        $period = [];
        $now = Carbon::now();
        $startOfMonth = $now->startOfMonth()->toDateString();
        $endOfMonth = $now->endOfMonth()->toDateString();
        $period = CarbonPeriod::create($startOfMonth, $endOfMonth)->toArray();

        return (object) [
            'now' => $now,
            'period' => $period
        ];
    }

    public function show($userId) {
        if ($userId != Auth::id()) { abort(404); }

        $data = $this->kintaiForMonth($userId);
        $kintais = $data->kintais;
        $id = $data->id;

        $monthly = $this->getMonthly();
        $now = $monthly->now;
        $period = $monthly->period;
        $workStarts = [];
        $workEnds = [];

        foreach ($period as $day) {
            $dateString = $day->toDateString();
            $columnName1 = 'work_start_' . $day->format('d');
            $columnName2 = 'work_end_' . $day->format('d');

            foreach ($kintais as $kintai) {
                $workStarts[$dateString] = isset($kintai->$columnName1) ?
                Carbon::parse($kintai->$columnName1)->format('H:i:s') : null;
                $workEnds[$dateString] = isset($kintai->$columnName2) ?
                Carbon::parse($kintai->$columnName2)->format('H:i:s') : null;
            }
        }

        return view('kintais.show', compact('id', 'now', 'period', 'workStarts', 'workEnds'));
    }

    public function create() {
        $userId = Auth::id();
        $data = $this->kintaiForMonth($userId);
        $kintais = $data->kintais;
        $id = $data->id;

        if ($kintais->isEmpty()) {
            return view('kintais.create');
        } else {
            return redirect()->route('stamp.kintais', $id);
        }
    }

    public function store(KintaiRequest $request) {
        $userId = Auth::id();
        $workStart = 'work_start_'. Carbon::now()->format('d');

        $kintai = new Kintai();
        $kintai->user_id = $userId;
        $kintai->this_month = $request->this_month;
        $kintai->$workStart = Carbon::now();
        $kintai->save();

        return redirect()->route('show.kintais', $userId);
    }

    public function stamp($id) {
        $kintai = Kintai::findOrFail($id);
        $this->getUserIdOrFail($kintai);

        $today = Carbon::now()->format('d');
        $workStart = 'work_start_' . $today;
        $workEnd = 'work_end_' . $today;

        return view('kintais.stamp')->with([
            'kintai' => $kintai,
            'workStart' => $kintai->$workStart,
            'workEnd' => $kintai->$workEnd
        ]);
    }

    public function update(Request $request, $id) {
        $kintai = Kintai::findOrFail($id);
        $this->getUserIdOrFail($kintai);

        $now = Carbon::now();
        $workStart = 'work_start_' . $now->format('d');
        $workEnd = 'work_end_' . $now->format('d');

        if ($request->has('work_start_') && !$kintai->$workStart) {
            $kintai->$workStart = $now;
        } elseif ($request->has('work_end_') && !$kintai->$workEnd) {
            $kintai->$workEnd = $now;
        } else {
            return redirect()->route('stamp.kintais', $kintai->id)
                ->with('error', 'すでに打刻されています。');
        }

        $kintai->save();
        return redirect()->route('show.kintais', $kintai->user_id);
    }

    public function edit($id) {
        $userId = Auth::id();
        $data = $this->kintaiForMonth($userId);
        $kintais = $data->kintais;
        $kintai = Kintai::findOrFail($id);
        $this->getUserIdOrFail($kintai);

        $monthly = $this->getMonthly();
        $now = $monthly->now;
        $period = $monthly->period;
        $workStarts = [];
        $workEnds = [];

        foreach ($period as $day) {
            $dateString = $day->toDateString();
            $columnName1 = 'work_start_' . $day->format('d');
            $columnName2 = 'work_end_' . $day->format('d');

            foreach ($kintais as $kintai) {
                $workStarts[$dateString] = isset($kintai->$columnName1) ?
                Carbon::parse($kintai->$columnName1)->format('H:i:s') : null;
                $workEnds[$dateString] = isset($kintai->$columnName2) ?
                Carbon::parse($kintai->$columnName2)->format('H:i:s') : null;
            }
        }

        return view('kintais.edit', compact('id', 'now', 'period', 'workStarts', 'workEnds'));
    }

    public function revision(Request $request, $id) {
        $userId = Auth::id();
        $data = $this->kintaiForMonth($userId);
        $kintais = $data->kintais;
        $kintai = Kintai::findOrFail($id);
        $this->getUserIdOrFail($kintai);

        $monthly = $this->getMonthly();
        $period = $monthly->period;

        foreach ($period as $day) {
            $workStartKey = 'work_start_' . $day->format('d');
            $workEndKey = 'work_end_' . $day->format('d');

            if ($request->has($workStartKey) && $request->input($workStartKey) !== null) {
                $time = $request->input($workStartKey);
                $kintai->$workStartKey = $day->toDateString() . ' ' . $time . ':00';
            }
            if ($request->has($workEndKey) && $request->input($workEndKey) !== null) {
                $time = $request->input($workEndKey);
                $kintai->$workEndKey = $day->toDateString() . ' ' . $time . ':00';
            }
        }

        $kintai->save();

        return redirect()->route('show.kintais', $userId);
    }
}
