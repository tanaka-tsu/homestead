@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card-body">
        <div class="card-header">管理者情報</div>
        @if (session('flash_message'))
            <div class="change-success">
                {{ session('flash_message') }}
            </div>
        @endif
        <div class="btn-flex">
            <div class="edit-btn">
                <a href="{{ route('admin.edit', $id) }}">
                    編集
                </a>
            </div>
            <div class="edit-btn">
                <a href="{{ route('admin.pass_form', $id) }}">
                    パスワード変更
                </a>
            </div>
        </div>
        <table border="1" align="center">
            <tr>
                <th>管理者ID</th>
                <td align="center">{{ $admin->admin_id }}</td>
            </tr>
            <tr>
                <th width="30%">名前</th>
                <td align="center">{{ $admin->name }}</td>
            </tr>
            <tr>
                <th>メールアドレス</th>
                <td align="center">{{ $admin->email }}</td>
            </tr>
        </table>

        <div class="second_content">管理者一覧</div>
        <table border="1" align="center">
            @foreach ($admins as $admin)
            <tr>
                <td align="center">{{ $admin->name }}</td>
            </tr>
            @endforeach
        </table>
        {{-- adminでログインしてる場合のみadminユーザーを追加できる --}}
        <div class="edit-btn options">
            <a href="{{ route('admin.register') }}">
                管理者新規登録
            </a>
        </div>

        <div class="edit-btn options">
            <a href="{{ route('options.index') }}">
                支社・勤務条件確認
            </a>
        </div>
    </div>
</div>
@endsection
