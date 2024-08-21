@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">新規登録</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="employee_number" class="col-md-4 col-form-label text-md-end">社員番号</label>

                            <div class="col-md-6">
                                <input id="employee_number" type="text" class="form-control @error('employee_number') is-invalid @enderror" name="employee_number" value="{{ old('employee_number') }}" required autocomplete="employee_number" autofocus>

                                @error('employee_number')
                                    <br>
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="branch_office" class="col-md-4 col-form-label text-md-end">所属</label>

                            <div class="col-md-6">
                                <select id="branch_office" class="form-control @error('branch_office') is-invalid @enderror" name="branch_office" required autocomplete="branch_office" autofocus>
                                    <option value="" hidden>選択してください</option>
                                    <option value="大阪本社" {{ old('branch_office') == '大阪本社' ? 'selected' : '' }}>大阪本社</option>
                                    <option value="東京支社" {{ old('branch_office') == '東京支社' ? 'selected' : '' }}>東京支社</option>
                                    <option value="名古屋支社" {{ old('branch_office') == '名古屋支社' ? 'selected' : '' }}>名古屋支社</option>
                                    <option value="福岡支社" {{ old('branch_office') == '福岡支社' ? 'selected' : '' }}>福岡支社</option>
                                </select>

                                @error('branch_office')
                                    <br>
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="terms" class="col-md-4 col-form-label text-md-end">区分</label>

                            <div class="col-md-6">
                                <select id="terms" class="form-control @error('terms') is-invalid @enderror" name="terms" required autocomplete="terms" autofocus>
                                    <option value="" hidden>選択してください</option>
                                    <option value="区分1" {{ old('terms') == '区分1' ? 'selected' : '' }}>区分1</option>
                                    <option value="区分2" {{ old('terms') == '区分2' ? 'selected' : '' }}>区分2</option>
                                    <option value="区分3" {{ old('terms') == '区分3' ? 'selected' : '' }}>区分3</option>
                                </select>

                                @error('terms')
                                    <br>
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">氏名</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <br>
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">メールアドレス</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
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
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <br>
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">パスワード（確認用）</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    登録する
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
