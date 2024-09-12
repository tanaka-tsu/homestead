<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    private function getKintaiForMonth($user_id, $month) {
        // 月ごとのレコードとそのidを取得
        $kintais = Kintai::where('user_id', $user_id)
                          ->where('this_month', 'like', "$month%")
                          ->get();
        $id = $kintais->pluck('id')->first();

        return (object) [
            'kintais' => $kintais,
            'id' => $id
        ];
    }

    private function getMonthly($select_month) {
        // 選択した月の月初から月末までを取得し配列に変換
        $period = [];
        $now = Carbon::parse($select_month);
        $start_of_month = $now->startOfMonth()->toDateString();
        $end_of_month = $now->endOfMonth()->toDateString();
        $period = CarbonPeriod::create($start_of_month, $end_of_month)->toArray();

        return (object) [
            'now' => $now,
            'period' => $period
        ];
    }

    private function getPastKintais($user_id) {
        return Kintai::where('user_id', $user_id)
                    ->orderBy('this_month', 'desc')
                    ->pluck('this_month');
    }

    public function show($model, $id) {
        if (Auth::guard('admin')->check() || $model == 'user' && $id == Auth::id()){
            if ($model == 'user') {
                $user = User::findOrFail($id);
                $user_id = $user->id;
                $kintai = Kintai::findOrFail($user_id);
                $this_month = Carbon::now()->format('Y-m');
            } elseif ($model == 'kintai') {
                // adminユーザーが検索から開く場合のルート
                $kintai = Kintai::findOrFail($id);
                $user_id = $kintai->user_id;
                $user = User::findOrFail($user_id);
                $this_month = $kintai->this_month;
            }

            // プルダウンで過去の勤怠データを選択した場合
            $select_month = request('this_month', $this_month);
            $past_kintais = $this->getPastKintais($user_id)->toArray();
            $select_month_format = Carbon::parse($select_month)->format('Y-m');
            $data = $this->getKintaiForMonth($user_id, $select_month);

            // 勤怠データが存在するかチェック
            $kintais = $data->kintais;
            $id = $data->id;
            $data_exists = !$kintais->isEmpty();

            // 今月のデータがない場合はプルダウンに選択肢を追加
            if (!$data_exists) {
                array_unshift($past_kintais, $this_month);
            }

            // 表の準備
            $monthly = $this->getMonthly($select_month);
            $period = $monthly->period;
            $work_starts = [];
            $work_ends = [];
            $work_hours = [];
            $attendance_judgment = [];
            $break_times = [];

            foreach ($period as $day) {
                $date_string = $day->toDateString();
                $columnName1 = 'work_start_' . $day->format('d');
                $columnName2 = 'work_end_' . $day->format('d');
                $columnName3 = 'break_time_' . $day->format('d');

                foreach ($kintais as $kintai) {
                    // カラムにデータがあれば時間形式で表示、なければnullを返す
                    $work_start = isset($kintai->$columnName1) ? Carbon::parse($kintai->$columnName1) : null;
                    $work_end = isset($kintai->$columnName2) ? Carbon::parse($kintai->$columnName2) : null;
                    $break_time = isset($kintai->$columnName3) ? Carbon::parse($kintai->$columnName3) : null;

                    $work_starts[$date_string] = $work_start ? $work_start->format('H:i') : null;
                    $work_ends[$date_string] = $work_end ? $work_end->format('H:i') : null;
                    $break_times[$date_string] = $break_time ? $break_time->format('H:i') : null;

                    if ($work_start && $work_end) {
                        // 勤務時間を計算し、15分刻みで繰り下げる
                        $break_time_minutes = $break_time ? $break_time->hour * 60 + $break_time->minute : 0;
                        $minutes_worked = $work_end->diffInMinutes($work_start) - $break_time_minutes;
                        $minutes_worked = floor($minutes_worked / 15) * 15;

                        $hours = floor($minutes_worked / 60);
                        $minutes = $minutes_worked % 60;
                        $work_hours[$date_string] = sprintf('%02d:%02d', $hours, $minutes);

                        if ($hours >= 8) {
                            $attendance_judgment[$date_string] = '○';
                        } elseif ($hours >= 4) {
                            $attendance_judgment[$date_string] = '△';
                        } else {
                            $attendance_judgment[$date_string] = '×';
                        }
                    } else {
                        $work_hours[$date_string] = null;
                    }
                }
            }

            return view('kintais.show', compact('id', 'user', 'period', 'work_starts', 'work_ends', 'break_times', 'work_hours', 'attendance_judgment', 'past_kintais', 'select_month', 'select_month_format', 'this_month', 'data_exists'));
        } else {
            abort(404);
        }
    }

    public function create() {
        $user_id = Auth::id();
        $now = Carbon::now();
        $month = $now->format('Y-m');
        $data = $this->getKintaiForMonth($user_id, $month);
        $kintais = $data->kintais;
        $id = $data->id;

        // 現在の月のレコードがなければ作成画面、あれば更新画面を返す
        if ($kintais->isEmpty()) {
            return view('kintais.create', compact('now'));
        } else {
            return redirect()->route('kintais.stamp', $id);
        }
    }

    public function store(Request $request) {
        $request->validate([
            'user_id' => 'required',
            'this_month' => 'required',
        ],[
            'user_id.required' => 'User IDが確認できません。',
            'this_month.required' => '年/月が確認できません。',
        ]);
        $now = Carbon::now();
        $work_start = 'work_start_'. $now->format('d');

        $kintai = new Kintai();
        $kintai->user_id = $request->user_id;
        $kintai->this_month = $request->this_month;
        $kintai->$work_start = $now;

        $kintai->save();

        return redirect()->route('kintais.show', ['model' => 'user', 'id' => $request->user_id]);
    }

    public function stamp($id) {
        $kintai = Kintai::findOrFail($id);
        $this->getUserIdOrFail($kintai);

        $now = Carbon::now();
        $today = $now->format('d');
        $work_start = 'work_start_' . $today;
        $work_end = 'work_end_' . $today;

        return view('kintais.stamp')->with([
            'kintai' => $kintai,
            'now' => $now,
            'work_start' => $kintai->$work_start,
            'work_end' => $kintai->$work_end,
        ]);
    }

    public function add(Request $request, $id) {
        $kintai = Kintai::findOrFail($id);
        $this->getUserIdOrFail($kintai);

        $now = Carbon::now();
        $work_start = 'work_start_' . $now->format('d');
        $work_end = 'work_end_' . $now->format('d');
        $break_time = 'break_time_' . $now->format('d');

        // リクエストにwork_start_の値が含まれており、かつ今日の$work_startが空であれば現在時刻を追加
        if ($request->has('work_start_') && !$kintai->$work_start) {
            $kintai->$work_start = $now;
        } elseif ($request->has('work_end_') && !$kintai->$work_end) {
            $kintai->$work_end = $now;
            if ($request->has('break_time_') && !$kintai->$break_time) {
                $kintai->$break_time = Carbon::createFromFormat('H:i', $request->input('break_time_'))->format('H:i');
            }
        } else {
            return redirect()->route('kintais.stamp', $id)
                ->with('error', 'すでに打刻されています。');
        }

        $kintai->save();

        return redirect()->route('kintais.show', ['model' => 'user', 'id' => $kintai->user_id]);
    }

    public function edit($id) {
        $user_id = Auth::id();
        $select_month = request('this_month', Carbon::now()->format('Y-m'));

        $data = $this->getKintaiForMonth($user_id, $select_month);
        $kintais = $data->kintais;
        $kintai = Kintai::findOrFail($id);
        $this->getUserIdOrFail($kintai);
        $monthly = $this->getMonthly($select_month);
        $now = $monthly->now;
        $period = $monthly->period;
        $work_starts = [];
        $work_ends = [];
        $break_times = [];

        foreach ($period as $day) {
            $date_string = $day->toDateString();
            $columnName1 = 'work_start_' . $day->format('d');
            $columnName2 = 'work_end_' . $day->format('d');
            $columnName3 = 'break_time_' . $day->format('d');

            foreach ($kintais as $kintai) {
                // カラムにデータがあれば時間形式で表示、なければnullを返す
                $work_starts[$date_string] = isset($kintai->$columnName1) ?
                Carbon::parse($kintai->$columnName1)->format('H:i') : null;
                $work_ends[$date_string] = isset($kintai->$columnName2) ?
                Carbon::parse($kintai->$columnName2)->format('H:i') : null;
                $break_times[$date_string] = isset($kintai->$columnName3) ?
                Carbon::parse($kintai->$columnName3)->format('H:i') : null;
            }
        }

        return view('kintais.edit', compact('id', 'user_id', 'now', 'period', 'work_starts', 'work_ends', 'break_times'));
    }

    public function update(Request $request, $id) {
        $kintai = Kintai::findOrFail($id);
        $select_month = request('this_month', Carbon::now()->format('Y-m'));
        $monthly = $this->getMonthly($select_month);
        $period = $monthly->period;

        foreach ($period as $day) {
            $date_string = $day->format('d');
            $work_start_key = 'work_start_' . $date_string;
            $work_end_key = 'work_end_' . $date_string;
            $break_time_key = 'break_time_' . $date_string;
            $delete_start_key = 'delete_start_' . $date_string;
            $delete_end_key = 'delete_end_' . $date_string;
            $delete_break_key = 'delete_break_' . $date_string;

            // 削除ボックスにチェックが入っていれば値をnullにする
            if ($request->has($delete_start_key)) {
                $kintai->$work_start_key = null;
            } elseif ($request->has($work_start_key) && $request->input($work_start_key) !== null) {
                // チェックが入っておらず、入力値がnullでなければ時間のみ上書き
                $time = $request->input($work_start_key);
                $kintai->$work_start_key = $day->toDateString() . ' ' . $time . '';
            }

            if ($request->has($delete_end_key)) {
                $kintai->$work_end_key = null;
            } elseif ($request->has($work_end_key) && $request->input($work_end_key) !== null) {
                $time = $request->input($work_end_key);
                $kintai->$work_end_key = $day->toDateString() . ' ' . $time . '';
            }

            if ($request->has($delete_break_key)) {
                $kintai->$break_time_key = null;
            } elseif ($request->has($break_time_key) && $request->input($break_time_key) !== null) {
                $time = $request->input($break_time_key);
                $kintai->$break_time_key = $day->toDateString() . ' ' . $time . '';
            }
        }

        $kintai->save();

        return redirect()->route('kintais.show', ['model' => 'user', 'id' => $kintai->user_id]);
    }
}
