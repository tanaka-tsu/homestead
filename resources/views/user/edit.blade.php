@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card-body">
        <div class="back"></div>
        <a href="{{ route('show.user', $id) }}" class="back-btn">戻る</a>
        <div class="card-header">社員情報の編集</div>

        <div class="employee-edit">
            <form action="{{ route('update.user', $id) }}" method='post'>
                @csrf
                @method('PATCH')

                <div class="edit-btn"><button type="submit">
                    編集完了
                </button></div>
                <table border="1" align="center">
                    <div class="user-edit"><label>
                        <tr>
                            <th width="30%">社員番号</th>
                            <td><input type="text" name="employee_id" value="{{ old('employee_id', $user->employee_id) }}"></td>
                        </tr>
                    </label></div>
                    @error('employee_id')
                        <div class="error">{{ $message }}</div>
                    @enderror
                    <div class="user-edit"><label>
                        <tr>
                            <th>所属</th>
                            <td><select name="office">
                                <option value="大阪本社" {{ old('office', $user->office) == '大阪本社' ? 'selected' : '' }}>大阪本社</option>
                                <option value="東京支社" {{ old('office', $user->office) == '東京支社' ? 'selected' : '' }}>東京支社</option>
                                <option value="名古屋支社" {{ old('office', $user->office) == '名古屋支社' ? 'selected' : '' }}>名古屋支社</option>
                                <option value="福岡支社" {{ old('office', $user->office) == '福岡支社' ? 'selected' : '' }}>福岡支社</option>
                            </select></td>
                        </tr>
                    </label></div>
                    @error('office')
                        <div class="error">{{ $message }}</div>
                    @enderror
                    <div class="user-edit"><label>
                        <tr>
                            <th>名前</th>
                            <td><input type="text" name="name" value="{{ old('name', $user->name) }}"></td>
                        </tr>
                    </label></div>
                    @error('name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                    <div class="user-edit"><label>
                        <tr>
                            <th>勤務時間</th>
                            <td><select name="terms">
                                <option value="9～18時" {{ old('terms', $user->terms) == '9～18時' ? 'selected' : '' }}>9～18時</option>
                                <option value="10～19時" {{ old('terms', $user->terms) == '10～19時' ? 'selected' : '' }}>10～19時</option>
                                <option value="その他" {{ old('terms', $user->terms) == 'その他' ? 'selected' : '' }}>その他</option>
                            </select></td>
                        </tr>
                    </label></div>
                    @error('terms')
                        <div class="error">{{ $message }}</div>
                    @enderror
                    <div class="user-edit"><label>
                        <tr>
                            <th>メールアドレス</th>
                            <td><input type="text" name="email" value="{{ old('email', $user->email) }}"></td>
                        </tr>
                    </label></div>
                    @error('email')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </table>
            </form>
        </div>
    </div>
</div>
@endsection
