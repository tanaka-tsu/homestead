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

        <div class="second_content">勤怠データ検索</div>
        <form action="{{ route('admin.search') }}" method="get">
            @csrf

            <div class="oputions-flex">
                <div class="input_form">
                    <input type="month" name="month" value="{{ old('month', now()->format('Y-m')) }}">
                </div>
                <div class="input_form">
                    <label>所属
                        <select name="office">
                            <option>未選択</option>
                            @foreach($locations as $location)
                            <option {{ old('office') == $location->office_name ? 'selected' : '' }}>{{ $location->office_name }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
                <div class="input_form">
                    <label>勤務条件
                        <select name="terms">
                            <option>未選択</option>
                            @foreach($conditions as $condition)
                            <option {{ old('terms') == $condition->detail ? 'selected' : '' }}>{{ $condition->detail }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
            </div>
            <div class="edit-btn"><button>検索</button></div>
        </form>

        @if (!empty($results))
            <table border="1" align="center">
                <tr>
                    <th colspan="2">検索結果</th>
                </tr>
                @if (!empty($message))
                    <tr>
                        <td colspan="2">{{ $message }}</td>
                    </tr>
                @endif
                @foreach ($results as $result)
                    <tr>
                        <td align="center">{{ \Carbon\Carbon::parse($result->this_month)->format('Y/m') }}</td>
                        <td align="center"><a href="{{ route('kintais.show', ['model' => 'kintai', 'id' => $result->id]) }}">{{ $result->user->name }}</a></td>
                    </tr>
                @endforeach
            </table>
        @endif
    </div>
</div>
@endsection
