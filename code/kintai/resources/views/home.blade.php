@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="{{ route('record') }}">
                {{ __('勤怠表') }}
            </a>

            @if ($status == 'before')
                <form method="POST" action="begin_work">
                    @csrf

                    <button type="submit">{{ __('出勤') }}</button>
                </form>
            @else
                <form>
                    @csrf

                    <button type="submit">{{ __('退勤') }}</button>
                    <label>休憩時間：<input type="time"></label>
                </form>
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
