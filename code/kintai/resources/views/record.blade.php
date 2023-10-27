@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <a href="{{ route('home') }}">
            {{ __('戻る') }}
        </a>

        <h1>勤怠表</h1>
        <div class="col-md-8">
            <table>
                <thead>
                    <tr>
                        <th>日付</th>
                        <th>出勤</th>
                        <th>退勤</th>
                        <th>休憩</th>
                        <th>勤務時間</th>
                    </tr>
                </thead>
                <tbody>
                @for ($i = 1; $i <= 31; $i++)
                    <tr>
                        <td>{{ $i }}日</td>
                        <td>{{ mb_substr($attendance['day'.$i.'_begin'], 0, 5) }}</td>
                        <td>{{ mb_substr($attendance['day'.$i.'_finish'], 0, 5) }}</td>
                        <td>{{ mb_substr($attendance['day'.$i.'_break'], 0, 5) }}</td>
                        <td>calculating...</td>
                    </tr>
                @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
