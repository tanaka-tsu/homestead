@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="{{ route('record') }}">
                {{ __('勤怠表') }}
            </a>

            @if ($status == 'before_work')
                <form method="POST" action="begin_work">
                    @csrf

                    <button type="submit">{{ __('出勤') }}</button>
                </form>

            @elseif ($status == 'during_work')
                <form method="POST" action="finish_work">
                    @csrf

                    <button type="submit">{{ __('退勤') }}</button>
                    <label>休憩時間：<input type="time" name="break_time"></label>
                </form>

            @elseif ($status == 'after_work')
                <p>本日の勤務は終了しました。お疲れさまでした。</p>

            @endif

            {{-- <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div> --}}
        </div>
    </div>
</div>
@endsection
