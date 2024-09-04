@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card-body">
        <div class="back"></div>
        <a href="{{ route('user.show', $id) }}" class="back-btn">戻る</a>
        <div class="card-header">社員情報の編集</div>

        <div class="employee-edit">
            <form action="{{ route('user.update', $id) }}" method='post'>
                @csrf
                @method('PATCH')

                <div class="edit-btn"><button type="submit">
                    編集完了
                </button></div>
                <table border="1" align="center">
                    <div class="user-edit"><label>
                        <tr><th width="30%">社員番号</th>
                            <td>
                                <input type="text" name="employee_id" value="{{ old('employee_id', $user->employee_id) }}">
                                @error('employee_id')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                    </label></div>

                    @if(Auth::check() && $auth_group === 'user')
                        {{-- userは所属と条件を編集できない --}}
                        <div class="user-edit"><label>
                            <tr><th>所属</th>
                                <td>
                                    <select name="office" style="display: none;">
                                        @foreach($locations as $location)
                                            <option {{ old('office', $user->office) == $location->office_name ? 'selected' : '' }}>{{ $location->office_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="not-edit">{{ $user->office }}</div>
                                </td>
                            </tr>
                        </label></div>

                        <div class="user-edit"><label>
                            <tr><th>条件</th>
                                <td>
                                    <select name="terms" style="display: none;">
                                        @foreach($conditions as $condition)
                                            <option {{ old('terms', $user->terms) == $condition->detail ? 'selected' : '' }}>{{ $condition->detail }}</option>
                                        @endforeach
                                    </select>
                                    <div class="not-edit">{{ $user->terms }}</div>
                                </td>
                            </tr>
                        </label></div>

                        <div class="user-edit"><label>
                            <tr><th>名前</th>
                                <td>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}">
                                    @error('name')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                        </label></div>

                        <div class="user-edit"><label>
                            <tr><th>メールアドレス</th>
                                <td>
                                    <input type="text" name="email" value="{{ old('email', $user->email) }}">
                                    @error('email')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                        </label></div>
                    @elseif(Auth::guard('admin')->check())
                        {{-- adminは名前とメールアドレスを編集できない --}}
                        <div class="user-edit"><label>
                            <tr><th>所属</th>
                                <td>
                                    <select name="office">
                                        @foreach($locations as $location)
                                            <option {{ old('office', $user->office) == $location->office_name ? 'selected' : '' }}>{{ $location->office_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('office')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                        </label></div>

                        <div class="user-edit"><label>
                            <tr><th>条件</th>
                                <td>
                                    <select name="terms">
                                        @foreach($conditions as $condition)
                                            <option {{ old('terms', $user->terms) == $condition->detail ? 'selected' : '' }}>{{ $condition->detail }}</option>
                                        @endforeach
                                    </select>
                                    @error('terms')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                        </label></div>

                        <div class="user-edit"><label>
                            <tr><th>名前</th>
                                <td>
                                    <input type="hidden" name="name" value="{{ old('name', $user->name) }}">
                                    <div class="not-edit">{{ $user->name }}</div>
                                </td>
                            </tr>
                        </label></div>

                        <input type="hidden" name="email" value="{{ old('email', $user->email) }}">
                    @endif
                </table>
            </form>
        </div>
    </div>
</div>
@endsection
