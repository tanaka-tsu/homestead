@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card-body">
        @if(Auth::guard('admin')->check())
            <div class="back"></div>
            <a href="{{ route('admin.index') }}" class="back-btn back-index">戻る</a>
            <div class="employee-data">
                <table border="1" align="center">
                    <tr>
                        <th width="20%">社員番号</th>
                        <th width="20%">所属</th>
                        <th width="30%">名前</th>
                        <th width="10%">勤務条件</th>
                    </tr>
                    <tr>
                        <td align="center">{{ $user->employee_id }}</td>
                        <td align="center">{{ $user->office }}</td>
                        <td align="center">{{ $user->name }}</td>
                        <td align="center">{{ $user->terms }}</td>
                    </tr>
                </table>
            </div>
        @endif
        <div class="card-header">{{ $user->name }}さんの勤怠表</div>

        @if ($id)
            <form method="GET" action="{{ route('kintais.show', ['model' => 'user', 'id' => $user->id]) }}">
                <div class="seledted-month">
                    <select name="this_month" onchange="this.form.submit()">
                        @foreach ($past_kintais as $month)
                        <option value="{{ $month }}" {{ $select_month == $month ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::parse($month)->format('Y/m') }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        @endif
        @if ($id && $user->id == Auth::id() && $select_month_format == $this_month)
            <div class="edit-btn"><a href="{{ route('kintais.edit', $id) }}">
                編集モード
            </a></div>
        @endif

        <div class="work-schedule">
            <table border="1" align="center">
                <thead>
                    <tr>
                        <th width="10%">日付</th>
                        <th width="15%">出勤時刻</th>
                        <th width="15%">退勤時刻</th>
                        <th width="15%">休憩時間</th>
                        <th width="15%">勤務時間</th>
                        <th width="10%">出勤判断</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($period as $day)
                        <tr align="center">
                            <td class="vertical-text {{ \Carbon\Carbon::parse($day)->isSunday() ? 'red-text' : '' }}">
                                {{ $day->isoFormat('MM/DD（ddd）') }}
                            </td>
                            <td>
                                {{ $work_starts[$day->toDateString()] ?? '' }}
                            </td>
                            <td>
                                {{ $work_ends[$day->toDateString()] ?? '' }}
                            </td>
                            <td>
                                {{ $break_times[$day->toDateString()] ?? '' }}
                            </td>
                            <td>
                                {{ $work_hours[$day->toDateString()] ?? '' }}
                            </td>
                            <td>
                                {{ $attendance_judgment[$day->toDateString()] ?? '' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
