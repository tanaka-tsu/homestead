@extends('layouts.app')
{{-- layoutsフォルダの中にあるapp.blade.phpを継承 --}}

@section('content')
{{-- @extends内の@yield('content')部分に@endsection部分までを表示させる宣言 --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ Auth::user()->fullname }}さんの勤怠表</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="year-month">{{ $now->format('Y/m') }}</div>
                    @if ($id)
                        <div class="edit-btn"><a href="{{ route('edit.kintais', $id) }}">
                            編集モード
                        </a></div>
                    @endif

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
                                @foreach ($period as $day)
                                    @php
                                        // 日曜日は赤文字にする
                                        $isSunday = \Carbon\Carbon::parse($day)->isSunday();
                                    @endphp
                                    <tr align="center">
                                        <td class="vertical-text {{ $isSunday ? 'red-text' : '' }}">
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
        </div>
    </div>
</div>
@endsection
