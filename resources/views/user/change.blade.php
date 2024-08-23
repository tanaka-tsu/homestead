@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">パスワードの変更</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="employee-edit">
                        <form action="{{ route('changePassword.user', $id) }}" method='post'>
                            @csrf
                            @method('PATCH')

                            <table border="1" align="center">
                                <div class="user-edit"><label>
                                    <tr>
                                        <th width="40%">現在のパスワード</th>
                                        <td><input id="password" type="password" class="form-control @error('current-password') is-invalid @enderror" name="current-password" autocomplete="new-password">
                                            @error('current-password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </td>
                                    </tr>
                                </label></div>

                                <div class="user-edit"><label>
                                    <tr>
                                        <th>新しいパスワード</th>
                                        <td><input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="new-password" autocomplete="new-password">
                                            @error('new-password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </td>
                                    </tr>
                                </label></div>

                                <div class="user-edit"><label>
                                    <tr>
                                        <th>新しいパスワード（確認用）</th>
                                        <td><input id="password-confirm" type="password" class="form-control" name="new-password_confirmation" autocomplete="new-password"></td>
                                    </tr>
                                </label></div>
                            </table>
                            <div class="edit-btn"><button type="submit">
                                変更完了
                            </button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
