@extends('layouts.app')
{{-- layoutsフォルダの中にあるapp.blade.phpを継承 --}}

@section('content')
{{-- @extends内の@yield('content')部分に@endsection部分までを表示させる宣言 --}}
<a href="{{ route('create.kintais') }}" class="re">打刻画面へ</a>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">勤務表</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="year-month">{{ $date }}</div>
                    <div class="work-schedule">
                        <table border="1" width="70%" align="center">
                            <thead>
                                <tr>
                                    <th width="20%">日付</th>
                                    <th width="20%">出勤</th>
                                    <th width="20%">退勤</th>
                                    <th width="20%">休憩出る</th>
                                    <th width="20%">休憩戻る</th>
                                </tr>
                            </theadv>
                            <tbody>
                                @foreach ($periods as $period)
                                    @foreach ($period as $day)
                                        @php
                                            $dayString = \Carbon\Carbon::parse($day)->toDateString();
                                            $isSunday = \Carbon\Carbon::parse($day)->isSunday();
                                        @endphp
                                        <tr align="center">
                                            <td class="vertical-text {{ $isSunday ? 'red-text' : '' }}">{{ \Carbon\Carbon::parse($day)->isoFormat('MM/DD（ddd）') }}</td>
                                            <td>{{ $workStarts[$dayString] ?? '' }}</td>
                                            <td>{{ $workEnds[$dayString] ?? '' }}</td>
                                            <td>{{ $breakStarts[$dayString] ?? '' }}</td>
                                            <td>{{ $breakEnds[$dayString] ?? '' }}</td>
                                        </tr>
                                    @endforeach
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
