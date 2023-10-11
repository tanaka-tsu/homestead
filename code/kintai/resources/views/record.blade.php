@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
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
                @for (int $i = 0; $i <= 31; $i++)
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
