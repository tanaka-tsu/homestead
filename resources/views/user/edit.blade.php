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
                                        <td><input type="text" name="employee_number" value="{{ old('employee_number', $user->employee_number) }}"></td>
                                    </tr>
                                </label></div>
                                @error('employee_number')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                                <div class="user-edit"><label>
                                    <tr>
                                        <th>所属</th>
                                        <td><select name="branch_office">
                                            <option value="大阪支社" {{ old('branch_office', $user->branch_office) == '大阪本社' ? 'selected' : '' }}>大阪本社</option>
                                            <option value="東京支社" {{ old('branch_office', $user->branch_office) == '東京支社' ? 'selected' : '' }}>東京支社</option>
                                            <option value="東京支社" {{ old('branch_office', $user->branch_office) == '東京支社' ? 'selected' : '' }}>名古屋支社</option>
                                            <option value="福岡支社" {{ old('branch_office', $user->branch_office) == '福岡支社' ? 'selected' : '' }}>福岡支社</option>
                                        </select></td>
                                    </tr>
                                </label></div>
                                @error('branch_office')
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
                                        <th>区分</th>
                                        <td><select name="terms">
                                            <option value="区分1" {{ old('terms', $user->terms) == '区分1' ? 'selected' : '' }}>区分1</option>
                                            <option value="区分2" {{ old('terms', $user->terms) == '区分2' ? 'selected' : '' }}>区分2</option>
                                            <option value="区分3" {{ old('terms', $user->terms) == '区分3' ? 'selected' : '' }}>区分3</option>
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
        </div>
    </div>
</div>
@endsection
