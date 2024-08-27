@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card-body">
        <div class="back"></div>
        <a href="{{ route('show.kintais', $userId) }}" class="back-btn">戻る</a>
        <div class="card-header">勤怠表の編集</div>

        <div class="year-month">{{ $now->format('Y/m') }}</div>
        <div class="work-schedule">
            <table border="1" align="center">
                <thead>
                    <tr>
                        <th width="15%">日付</th>
                        <th width="20%">出勤時刻</th>
                        <th width="20%">退勤時刻</th>
                    </tr>
                </thead>
                <tbody>
                    <form action="{{ route('update.kintais', $id) }}" method='post'>
                        @csrf
                        @method('PATCH')

                        @foreach ($period as $day)
                            <tr align="center">
                                <td class="vertical-text {{ \Carbon\Carbon::parse($day)->isSunday() ? 'red-text' : '' }}">
                                    {{ $day->isoFormat('MM/DD（ddd）') }}
                                </td>
                                <td>
                                    <label>
                                        <input type="time" name="work_start_{{ $day->format('d') }}" value="{{ $workStarts[$day->toDateString()] ?? '' }}">
                                        <input type="checkbox" name="delete_start_{{ $day->format('d') }}"><span class="delete">削除</span>
                                    </label>
                                </td>
                                <td>
                                    <label>
                                        <input type="time" name="work_end_{{ $day->format('d') }}" value="{{ $workEnds[$day->toDateString()] ?? '' }}">
                                        <input type="checkbox" name="delete_end_{{ $day->format('d') }}"><span class="delete">削除</span>
                                    </label>
                                </td>
                            </tr>
                        @endforeach
                        <div class="edit-btn"><button type="submit">
                            編集完了
                        </button></div>
                    </form>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
