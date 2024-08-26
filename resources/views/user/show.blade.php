@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card-body">
        <div class="card-header">社員情報</div>

        <div class="edit-btn mypage-edit">
            <a href="{{ route('edit.user', $id) }}">
                編集
            </a>
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
                    <th>名前</th>
                    <td align="center">{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>勤務時間</th>
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
                パスワード変更
            </a>
        </div>
        @if (session('flash_message'))
            <div class="change-success">
                {{ session('flash_message') }}
            </div>
        @endif
    </div>
</div>
@endsection
