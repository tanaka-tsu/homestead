@extends('layouts.app')
{{-- layoutsフォルダの中にあるapp.blade.phpを継承 --}}

@section('content')
{{-- @extends内の@yield('content')部分に@endsection部分までを表示させる宣言 --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">勤務表の編集</div>

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
                                    <th width="20%">日付</th>
                                    <th width="20%">出勤</th>
                                    <th width="20%">退勤</th>
                                </tr>
                            </thead>
                            <tbody>
                                <form action="{{ route('revision.kintais', $id) }}" method='post'>
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
                                                <input type="time" name="work_start_{{ $day->format('d') }}" value="{{ isset($workStarts[$day->toDateString()]) ? \Carbon\Carbon::parse($workStarts[$day->toDateString()])->format('H:i') : '' }}">
                                            </td>
                                            <td>
                                                <input type="time" name="work_end_{{ $day->format('d') }}" value="{{ isset($workEnds[$day->toDateString()]) ? \Carbon\Carbon::parse($workEnds[$day->toDateString()])->format('H:i') : '' }}">
                                        </tr>
                                    @endforeach
                                    <button type="submit" class="edit-btn">
                                        編集する
                                    </button>
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
