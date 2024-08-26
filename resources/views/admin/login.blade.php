@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card-body">
        <div class="card-header">管理者ログイン</div>
        <form method="POST" action="{{ route('loggedIn.admin') }}">
            @csrf

            <div class="row mb-3">
                <label for="admin_id" class="col-md-4 col-form-label text-md-end">管理者ID</label>
                <div class="col-md-6">
                    <input id="admin_id" type="text" class="form-control @error('admin_id') is-invalid @enderror" name="admin_id" value="{{ old('admin_id') }}" required autocomplete="admin_id" autofocus>
                    @error('admin_id')
                        <br>
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="password" class="col-md-4 col-form-label text-md-end">パスワード</label>
                <div class="col-md-6">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                        <br>
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6 offset-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            ログイン情報を保存する
                        </label>
                    </div>
                </div>
            </div>
            <div class="row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        ログイン
                    </button>
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            パスワードを忘れた場合
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
