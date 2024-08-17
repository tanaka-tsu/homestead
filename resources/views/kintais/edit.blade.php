@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">勤怠打刻</div>
                <div class="today">{{ Carbon\Carbon::now()->format("Y/m/d") }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ route('update.kintais', $kintai->id) }}" method='post'>
                        @csrf
                        @method('PATCH')

                        @if(is_null($workStart))
                            <div class="stamp-btn"><button type="submit" name="work_start_">出勤</button></div>
                        @elseif(is_null($workEnd))
                            <div class="stamp-btn"><button type="submit" name="work_end_">退勤</button></div>
                        @else
                            <div class="error">本日のデータは打刻済みです。</div>
                        @endif
                        @if (session('error'))
                            <div class="error">{{ session('error') }}</div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
