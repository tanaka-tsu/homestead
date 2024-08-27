@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card-body">
        <div class="card-header">社員一覧</div>

        <table border="1" align="center">
            <tr>
                <th width="20%">社員番号</th>
                <th width="20%">所属</th>
                <th width="30%">名前</th>
                <th width="10%">勤務条件</th>
            </tr>
            @foreach ($users as $user)
                <tr>
                    <td align="center">{{ $user->employee_id }}</td>
                    <td align="center">{{ $user->office }}</td>
                    <td align="center"><a href="{{ route('show.kintais', ['userId' => $user->id]) }}">{{ $user->name }}</a></td>
                    <td align="center">{{ $user->terms }}</td>
                </tr>
            @endforeach
        </table>
        {{ $users->links() }}

        <div class="adminis">管理者一覧</div>
        @foreach ($admins as $admin)
            <div class="administrators-list">
                <p>{{ $admin->name }}</p>
            </div>
        @endforeach
    </div>
</div>
@endsection
