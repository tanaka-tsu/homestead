@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">ログイン</div>

        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @error('employee_id')
                    <div class="error">{{ $errors->first('employee_id') }}</div>
                @enderror
                @error('password')
                    <div class="error">{{ $errors->first('password') }}</div>
                @enderror
                @csrf

                <div class="row mb-3">
                    <label for="employee_id" class="col-md-4 col-form-label text-md-end">社員番号</label>
                    <div class="input_form col-md-6">
                        <input id="employee_id" type="text" name="employee_id" value="{{ old('employee_id') }}" required autocomplete="employee_id" autofocus>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="password" class="col-md-4 col-form-label text-md-end">パスワード</label>
                    <div class="input_form col-md-6">
                        <input id="password" type="password" name="password" required autocomplete="current-password">
                    </div>
                </div>

                {{-- <div class="row mb-3">
                    <div class="col-md-6 offset-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                ログイン情報を保存する
                            </label>
                        </div>
                    </div>
                </div> --}}

                <div class="row mb-0">
                    <div class="edit-btn col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            ログイン
                        </button>

                        {{-- @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                パスワードを忘れた場合
                            </a>
                        @endif --}}
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
