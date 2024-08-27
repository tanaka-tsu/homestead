<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\KintaiRequest;
use App\Models\Kintai;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class KintaiController extends Controller
{
    public function __construct() {
       $this->middleware('auth')->except('show');
    }

    private function getUserIdOrFail($kintai) {
        // user_idとカレントユーザーが一致していなければ404を返す
        if ($kintai->user_id != Auth::id()) { abort(404); }
    }

    private function kintaiForMonth($userId, $month) {
        // 月ごとのレコードとそのidを取得
        $kintais = Kintai::where('user_id', $userId)
                          ->where('this_month', 'like', "$month%")
                          ->get();
        $id = $kintais->pluck('id')->first();

        return (object) [
            'kintais' => $kintais,
            'id' => $id
        ];
    }

    private function getMonthly($selectedMonth) {
        // 選択した月の月初から月末までを取得し配列に変換
        $period = [];
        $now = Carbon::parse($selectedMonth);
        $startOfMonth = $now->startOfMonth()->toDateString();
        $endOfMonth = $now->endOfMonth()->toDateString();
        $period = CarbonPeriod::create($startOfMonth, $endOfMonth)->toArray();

        return (object) [
            'now' => $now,
            'period' => $period
        ];
    }

    private function getPastKintais($userId) {
        return Kintai::where('user_id', $userId)
                    ->orderBy('this_month', 'desc')
                    ->pluck('this_month');
    }

    public function show($userId) {
        if ($userId == Auth::id() || Auth::guard('admin')->check()) {
            $user = User::findOrFail($userId);
            $pastKintais = $this->getPastKintais($userId);

            $currentMonth = Carbon::now()->format('Y-m');
            $selectedMonth = request('this_month', $currentMonth);
            $selectedMonthFormat = Carbon::parse($selectedMonth)->format('Y-m');

            $data = $this->kintaiForMonth($userId, $selectedMonth);
            $kintais = $data->kintais;
            $id = $data->id;

            $monthly = $this->getMonthly($selectedMonth);
            $period = $monthly->period;
            $workStarts = [];
            $workEnds = [];
            $workHours = [];
            $attendanceJudgment = [];
            $breakTimes = [];

            foreach ($period as $day) {
                // カラム名を合わせる
                $dateString = $day->toDateString();
                $columnName1 = 'work_start_' . $day->format('d');
                $columnName2 = 'work_end_' . $day->format('d');
                $columnName3 = 'break_time_' . $day->format('d');

                foreach ($kintais as $kintai) {
                    // カラムにデータがあれば時間形式で表示、なければnullを返す
                    $workStart = isset($kintai->$columnName1) ? Carbon::parse($kintai->$columnName1) : null;
                    $workEnd = isset($kintai->$columnName2) ? Carbon::parse($kintai->$columnName2) : null;
                    $breakTime = isset($kintai->$columnName3) ? Carbon::parse($kintai->$columnName3) : null;

                    $workStarts[$dateString] = $workStart ? $workStart->format('H:i') : null;
                    $workEnds[$dateString] = $workEnd ? $workEnd->format('H:i') : null;
                    $breakTimes[$dateString] = $breakTime ? $breakTime->format('H:i') : null;

                    if ($workStart && $workEnd) {
                        // 勤務時間を計算し、15分刻みで繰り下げる
                        $breakTimeInMinutes = $breakTime ? $breakTime->hour * 60 + $breakTime->minute : 0;
                        $minutesWorked = $workEnd->diffInMinutes($workStart) - $breakTimeInMinutes; // 休憩時間を引く
                        $minutesWorked = floor($minutesWorked / 15) * 15;

                        // 分を時間と分に変換
                        $hours = floor($minutesWorked / 60);
                        $minutes = $minutesWorked % 60;
                        $workHours[$dateString] = sprintf('%02d:%02d', $hours, $minutes);

                        if ($hours >= 8) {
                            $attendanceJudgment[$dateString] = '○';
                        } elseif ($hours >= 4) {
                            $attendanceJudgment[$dateString] = '△';
                        } else {
                            $attendanceJudgment[$dateString] = '×';
                        }
                    } else {
                        $workHours[$dateString] = null;
                    }
                }
            }

            return view('kintais.show', compact('id', 'user', 'period', 'workStarts', 'workEnds', 'workHours', 'attendanceJudgment', 'breakTimes', 'pastKintais', 'currentMonth', 'selectedMonth', 'selectedMonthFormat'));
        } else {
            abort(404);
        }
    }

    public function create() {
        $userId = Auth::id();
        $now = Carbon::now();
        $month = $now->format('Y-m');
        $data = $this->kintaiForMonth($userId, $month);
        $kintais = $data->kintais;
        $id = $data->id;

        // 現在の月のレコードがなければ作成画面、あれば更新画面を返す
        if ($kintais->isEmpty()) {
            return view('kintais.create', compact('now'));
        } else {
            return redirect()->route('stamp.kintais', $id);
        }
    }

    public function store(KintaiRequest $request) {
        $now = Carbon::now();
        $workStart = 'work_start_'. $now->format('d');

        // レコード作成に必要なデータを入れる
        $kintai = new Kintai();
        $kintai->user_id = $request->user_id;
        $kintai->this_month = $request->this_month;
        $kintai->$workStart = $now;

        $kintai->save();

        return redirect()->route('show.kintais', $kintai->user_id);
    }

    public function stamp($id) {
        $kintai = Kintai::findOrFail($id);
        $this->getUserIdOrFail($kintai);

        // 今日のカラム名を取得
        $now = Carbon::now();
        $today = $now->format('d');
        $workStart = 'work_start_' . $today;
        $workEnd = 'work_end_' . $today;
        $breakTime = 'break_time_' . $today;

        return view('kintais.stamp')->with([
            'kintai' => $kintai,
            'now' => $now,
            'workStart' => $kintai->$workStart,
            'workEnd' => $kintai->$workEnd,
            'breakTime' => $kintai->$breakTime,
        ]);
    }

    public function add(Request $request, $id) {
        $kintai = Kintai::findOrFail($id);
        $this->getUserIdOrFail($kintai);

        $now = Carbon::now();
        $workStart = 'work_start_' . $now->format('d');
        $workEnd = 'work_end_' . $now->format('d');
        $breakTime = 'break_time_' . $now->format('d');

        // リクエストにwork_start_の値が含まれており、かつ今日の$workStartが空であれば現在時刻を追加
        if ($request->has('work_start_') && !$kintai->$workStart) {
            $kintai->$workStart = $now;
        } elseif ($request->has('work_end_') && !$kintai->$workEnd) {
            $kintai->$workEnd = $now;
            $kintai->$breakTime = Carbon::createFromFormat('H:i', $request->input('break_time_'))->format('H:i');
        } else {
            return redirect()->route('stamp.kintais', $id)
                ->with('error', 'すでに打刻されています。');
        }

        $kintai->save();

        return redirect()->route('show.kintais', $kintai->user_id);
    }

    public function edit($id) {
        $userId = Auth::id();
        $selectedMonth = request('this_month', Carbon::now()->format('Y-m'));

        $data = $this->kintaiForMonth($userId, $selectedMonth);
        $kintais = $data->kintais;
        $kintai = Kintai::findOrFail($id);
        $this->getUserIdOrFail($kintai);
        $monthly = $this->getMonthly($selectedMonth);
        $now = $monthly->now;
        $period = $monthly->period;
        $workStarts = [];
        $workEnds = [];
        $breakTimes = [];

        foreach ($period as $day) {
            // カラム名を合わせる
            $dateString = $day->toDateString();
            $columnName1 = 'work_start_' . $day->format('d');
            $columnName2 = 'work_end_' . $day->format('d');
            $columnName3 = 'break_time_' . $day->format('d');

            foreach ($kintais as $kintai) {
                // カラムにデータがあれば時間形式で表示、なければnullを返す
                $workStarts[$dateString] = isset($kintai->$columnName1) ?
                Carbon::parse($kintai->$columnName1)->format('H:i') : null;
                $workEnds[$dateString] = isset($kintai->$columnName2) ?
                Carbon::parse($kintai->$columnName2)->format('H:i') : null;
                $breakTimes[$dateString] = isset($kintai->$columnName3) ?
                Carbon::parse($kintai->$columnName3)->format('H:i') : null;
            }
        }

        return view('kintais.edit', compact('id', 'userId', 'now', 'period', 'workStarts', 'workEnds', 'breakTimes'));
    }

    public function update(Request $request, $id) {
        $kintai = Kintai::findOrFail($id);
        $selectedMonth = request('this_month', Carbon::now()->format('Y-m'));
        $monthly = $this->getMonthly($selectedMonth);
        $period = $monthly->period;

        foreach ($period as $day) {
            // フォームのnameと合わせる
            $dateString = $day->format('d');
            $workStartKey = 'work_start_' . $dateString;
            $workEndKey = 'work_end_' . $dateString;
            $breakTimeKey = 'break_time_' . $dateString;
            $deleteStartKey = 'delete_start_' . $dateString;
            $deleteEndKey = 'delete_end_' . $dateString;
            $deleteBreakKey = 'delete_break_' . $dateString;

            // 削除ボックスにチェックが入っていれば値をnullにする
            if ($request->has($deleteStartKey)) {
                $kintai->$workStartKey = null;
            } elseif ($request->has($workStartKey) && $request->input($workStartKey) !== null) {
                // チェックが入っておらず、入力値がnullでなければ時間のみ上書き
                $time = $request->input($workStartKey);
                $kintai->$workStartKey = $day->toDateString() . ' ' . $time . '';
            }

            if ($request->has($deleteEndKey)) {
                $kintai->$workEndKey = null;
            } elseif ($request->has($workEndKey) && $request->input($workEndKey) !== null) {
                $time = $request->input($workEndKey);
                $kintai->$workEndKey = $day->toDateString() . ' ' . $time . '';
            }

            if ($request->has($deleteBreakKey)) {
                $kintai->$breakTimeKey = null;
            } elseif ($request->has($breakTimeKey) && $request->input($breakTimeKey) !== null) {
                $time = $request->input($breakTimeKey);
                $kintai->$breakTimeKey = $day->toDateString() . ' ' . $time . '';
            }
        }

        $kintai->save();

        return redirect()->route('show.kintais', $kintai->user_id);
    }
}
