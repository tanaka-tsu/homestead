@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card-body">
        <div class="card-header">勤怠打刻</div>
        <div class="today">{{ $now->format("Y/m/d") }}</div>

        <form action="{{ route('kintais.store') }}" method='post'>
            @csrf

            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
            @error('user_id')
                <div class="error">{{ $message }}</div>
            @enderror
            <input type="hidden" name="this_month" value="{{ $now->format("Y/m/d") }}">
            @error('this_month')
                <div class="error">{{ $message }}</div>
            @enderror
            <div class="stamp-btn"><button type="submit" name="work_start_">出勤</button></div>
        </form>
    </div>
</div>
@endsection
