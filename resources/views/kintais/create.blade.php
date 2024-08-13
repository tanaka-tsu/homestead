@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">勤怠打刻</div>
                <div class="today">{{ Carbon\Carbon::now()->format("Y/m/d") }}</div>
                {{-- <div class="now">{{ Carbon\Carbon::now()->format("H:i:s") }}</div> --}}

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ route('store.kintais') }}" method='post'>
                        @csrf

                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                        <input type="hidden" name="date" value="{{ Carbon\Carbon::now()->format('Y/m') }}">
                        <div class="stamp-btn"><button type="submit" name="work_start_">出勤</button></div>
                        @error('user_id')
                          <div class="error">{{ $message }}</div>
                        @enderror
                    </form>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
