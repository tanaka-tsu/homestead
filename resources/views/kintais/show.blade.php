@extends('layouts.app')
{{-- layoutsフォルダの中にあるapp.blade.phpを継承 --}}

@section('content')
{{-- @extends内の@yield('content')部分に@endsection部分までを表示させる宣言 --}}
<div class="container">
    <div class="card-body">
        <div class="card-header">{{ $user->name }}さんの勤怠表</div>

        @if(Auth::guard('admin')->check())
            <div class="work-schedule">
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

        <form method="GET" action="{{ route('show.kintais', ['userId' => $user->id]) }}">
            <div class="seledted-month">
                <select name="this_month" onchange="this.form.submit()">
                    @foreach ($pastKintais as $month)
                    <option value="{{ $month }}" {{ $selectedMonth == $month ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::parse($month)->format('Y/m') }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
        @if ($selectedMonthFormat == $currentMonth && $user->id == Auth::id())
            <div class="edit-btn"><a href="{{ route('edit.kintais', $id) }}">
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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($period as $day)
                        <tr align="center">
                            <td class="vertical-text {{ \Carbon\Carbon::parse($day)->isSunday() ? 'red-text' : '' }}">
                                {{ $day->isoFormat('MM/DD（ddd）') }}
                            </td>
                            <td>
                                {{ $workStarts[$day->toDateString()] ?? '' }}
                            </td>
                            <td>
                                {{ $workEnds[$day->toDateString()] ?? '' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
