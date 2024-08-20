@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">勤怠表の編集</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="year-month">{{ $now->format('Y/m') }}</div>
                    <div class="work-schedule">
                        <table border="1" align="center">
                            <thead>
                                <tr>
                                    <th width="15%">日付</th>
                                    <th width="20%">出勤</th>
                                    <th width="20%">退勤</th>
                                </tr>
                            </thead>
                            <tbody>
                                <form action="{{ route('update.kintais', $id) }}" method='post'>
                                    @csrf
                                    @method('PATCH')

                                    @foreach ($period as $day)
                                        @php
                                            $isSunday = \Carbon\Carbon::parse($day)->isSunday();
                                        @endphp
                                        <tr align="center">
                                            <td class="vertical-text {{ $isSunday ? 'red-text' : '' }}">
                                                {{ $day->isoFormat('MM/DD（ddd）') }}
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="time" name="work_start_{{ $day->format('d') }}" value="{{ isset($workStarts[$day->toDateString()]) ? \Carbon\Carbon::parse($workStarts[$day->toDateString()])->format('H:i') : '' }}">
                                                    <input type="checkbox" name="delete_start_{{ $day->format('d') }}"><span class="delete">削除</span>
                                                </label>
                                            </td>
                                            <td>
                                                <label>
                                                    <input type="time" name="work_end_{{ $day->format('d') }}" value="{{ isset($workEnds[$day->toDateString()]) ? \Carbon\Carbon::parse($workEnds[$day->toDateString()])->format('H:i') : '' }}">
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
        </div>
    </div>
</div>
@endsection
