@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card-body">
        <div class="card-header">勤怠打刻</div>
        <div class="today">{{ $now->format("Y/m/d") }}</div>

        <form action="{{ route('add.kintais', $kintai->id) }}" method='post'>
            @csrf
            @method('PATCH')

            {{-- $workStartがnullなら出勤ボタンを表示 --}}
            @if(is_null($workStart))
                <div class="stamp-btn"><button type="submit" name="work_start_">出勤</button></div>
            {{-- $workStartがnullでなく、$workEndがnullなら退勤ボタンを表示 --}}
            @elseif(is_null($workEnd))
                <div class="stamp-btn"><button type="submit" name="work_end_">退勤</button></div>
            @else
            {{-- $workStartも$workEndもnullでなければ打刻済みと表示 --}}
                <div class="error">本日のデータは打刻済みです。</div>
            @endif
            {{-- 何らかの形で再打刻しようとした場合はエラー表示 --}}
            @if (session('error'))
                <div class="error">{{ session('error') }}</div>
            @endif
        </form>
    </div>
</div>
@endsection
