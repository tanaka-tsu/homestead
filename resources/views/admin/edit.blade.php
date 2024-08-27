@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card-body">
        <div class="back"></div>
        <a href="{{ route('admin.show', $id) }}" class="back-btn">戻る</a>
        <div class="card-header">管理者情報の編集</div>

        <div class="employee-edit">
            <form action="{{ route('admin.update', $id) }}" method='post'>
                @csrf
                @method('PATCH')

                <div class="edit-btn"><button type="submit">
                    編集完了
                </button></div>
                <table border="1" align="center">
                    <div class="user-edit"><label>
                        <tr>
                            <th>名前</th>
                            <td><input type="text" name="name" value="{{ old('name', $admin->name) }}"></td>
                        </tr>
                    </label></div>
                    @error('name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                    <div class="user-edit"><label>
                        <tr>
                            <th>メールアドレス</th>
                            <td><input type="text" name="email" value="{{ old('email', $admin->email) }}"></td>
                        </tr>
                    </label></div>
                    @error('email')
                        <div class="error">{{ $message }}</div>
                    @enderror
                    <div class="user-edit"><label>
                        <tr>
                            <th>管理者ID</th>
                            <td><input type="text" name="admin_id" value="{{ old('admin_id', $admin->admin_id) }}"></td>
                        </tr>
                    </label></div>
                    @error('admin_id')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </table>
            </form>
        </div>
    </div>
</div>
@endsection
