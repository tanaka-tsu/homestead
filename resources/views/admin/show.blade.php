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

        <div class="third_content">支社・条件の編集</div>
        <div class="third_content-flex">
            <div class="third_content-1">
                <form action="{{ route('options.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="type" value="location">
                    <div class="input_form">
                        <input type="text" name="office_name">
                    </div>
                    <div class="edit-btn options-add">
                        <button type="submit">支社を追加</button>
                    </div>
                </form>
                <table border="1" align="center">
                    @foreach($locations as $location)
                    <tr>
                        <td><div class="not-edit">
                            {{ $location->office_name }}
                        </div></td>
                        <td>
                            <form action="{{ route('options.locationDestroy', $location->id) }}" method="post">
                                @method('delete')
                                @csrf

                                <button class="options-del">×</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>

            <div class="third_content-2">
                <form action="{{ route('options.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="condition">
                    <div class="input_form">
                        <input type="text" name="detail">
                    </div>
                    <div class="edit-btn options-add">
                        <button type="submit">条件を追加</button>
                    </div>
                </form>
                <table border="1" align="center">
                    @foreach($conditions as $condition)
                        <tr>
                            <td><div class="not-edit">
                                {{ $condition->detail }}
                            </div></td>
                            <td>
                                <form action="{{ route('options.conditionDestroy', $condition->id) }}" method="post">
                                    @method('delete')
                                    @csrf

                                    <button class="options-del">×</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

        <div class="second_content">管理者一覧</div>
        <table border="1" align="center">
            @foreach ($admins as $admin)
            <tr>
                <td align="center">{{ $admin->name }}</td>
            </tr>
            @endforeach
        </table>
        {{-- adminでログインしてる場合のみadminユーザーを追加できる --}}
        <div class="edit-btn">
            <a href="{{ route('admin.register') }}">＋</a>
        </div>
    </div>
</div>
@endsection
