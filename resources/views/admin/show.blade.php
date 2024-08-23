@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card-body">
        <div class="card-header">管理者情報</div>

        <div class="edit-btn mypage-edit">
            <a href="{{ route('edit.admin', $id) }}">
                編集
            </a>
        </div>
        <div class="employee-info">
            <table border="1" align="center">
                <tr>
                    <th>名前</th>
                    <td align="center">{{ $admin->name }}</td>
                </tr>
                <tr>
                    <th>メールアドレス</th>
                    <td align="center">{{ $admin->email }}</td>
                </tr>
                <tr>
                    <th>管理者ID</th>
                    <td align="center">{{ $admin->admin_id }}</td>
                </tr>
            </table>
        </div>
        <div class="edit-btn mypage-edit">
            <a href="{{ route('passwordForm.admin', $id) }}">
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
