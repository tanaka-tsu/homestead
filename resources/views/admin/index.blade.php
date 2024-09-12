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
            @foreach ($users_list as $user)
                <tr>
                    <td align="center">{{ $user->employee_id }}</td>
                    <td align="center">{{ $user->office }}</td>
                    <td align="center" class="td-a"><a href="{{ route('kintais.show', ['model' => 'user', 'id' => $user->id]) }}">{{ $user->name }}</a></td>
                    <td align="center" class="td-a"><a href="{{ route('user.edit', $user->id) }}">{{ $user->terms }}</a></td>
                </tr>
            @endforeach
        </table>
        {{ $users_list->links() }}
    </div>
</div>
@endsection
