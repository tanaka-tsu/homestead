@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">社員情報</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="edit-btn mypage-edit">
                        <a href="{{ route('edit.user', $id) }}">
                            編集する
                        </a>
                    </div>
                    <div class="employee-info">
                        <table border="1" align="center">
                            <tr>
                                <th width="30%">社員番号</th>
                                <td align="center">{{ $user->employee_number }}</td>
                            </tr>
                            <tr>
                                <th>所属</th>
                                <td align="center">{{ $user->branch_office }}</td>
                            </tr>
                            <tr>
                                <th>名前</th>
                                <td align="center">{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>区分</th>
                                <td align="center">{{ $user->terms }}</td>
                            </tr>
                            <tr>
                                <th>メールアドレス</th>
                                <td align="center">{{ $user->email }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="edit-btn mypage-edit">
                        <a href="{{ route('passwordForm.user', $id) }}">
                            パスワードを変更する
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
