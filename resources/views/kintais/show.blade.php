@extends('layouts.app')
{{-- layoutsフォルダの中にあるapp.blade.phpを継承 --}}

@section('content')
{{-- @extends内の@yield('content')部分に@endsection部分までを表示させる宣言 --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ Auth::user()->fullname }}さんの勤務表</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="year-month">{{ \Carbon\Carbon::now()->isoFormat('YYYY/MM') }}</div>

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
                                @foreach ($period as $day)
                                    @php
                                        $isSunday = \Carbon\Carbon::parse($day)->isSunday();
                                    @endphp
                                    <tr align="center">
                                        <td class="vertical-text {{ $isSunday ? 'red-text' : '' }}">{{ $day->isoFormat('MM/DD（ddd）') }}</td>
                                        <td>{{ isset($workStarts[$day->toDateString()]) ? \Carbon\Carbon::parse($workStarts[$day->toDateString()])->format('H:i:s') : '' }}</td>
                                        <td>{{ isset($workEnds[$day->toDateString()]) ? \Carbon\Carbon::parse($workEnds[$day->toDateString()])->format('H:i:s') : '' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
