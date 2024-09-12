@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card-body">
        <div class="card-header">社員情報</div>
        @if (session('flash_message'))
            <div class="change-success">
                {{ session('flash_message') }}
            </div>
        @endif
        <div class="btn-flex">
            <div class="edit-btn mypage-edit">
                <a href="{{ route('user.edit', $id) }}">
                    編集
                </a>
            </div>
            <div class="edit-btn mypage-edit">
                <a href="{{ route('user.pass_form', $id) }}">
                    パスワード変更
                </a>
            </div>
        </div>
        <div class="employee-info">
            <table border="1" align="center">
                <tr>
                    <th width="30%">社員番号</th>
                    <td align="center">{{ $user->employee_id }}</td>
                </tr>
                <tr>
                    <th>所属</th>
                    <td align="center">{{ $user->office }}</td>
                </tr>
                <tr>
                    <th>勤務条件</th>
                    <td align="center">{{ $user->terms }}</td>
                </tr>
                <tr>
                    <th>名前</th>
                    <td align="center">{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>メールアドレス</th>
                    <td align="center">{{ $user->email }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
