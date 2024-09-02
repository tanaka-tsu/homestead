@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card-body">
        <div class="back"></div>
        <a href="{{ route('admin.show', $id) }}" class="back-btn">戻る</a>
        <div class="card-header">支社・勤務条件の確認</div>
            <form action="{{ route('options.store') }}" method="POST">
                @csrf

                <input type="hidden" name="type" value="location">
                <div class="oputions-flex">
                    <div class="input_form">
                        <input type="text" name="office_name">
                    </div>
                    <div class="edit-btn options-add">
                        <button type="submit">支社を追加</button>
                    </div>
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

            <div class="options">
                <form action="{{ route('options.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="type" value="condition">
                    <div class="oputions-flex">
                        <div class="input_form">
                            <input type="text" name="detail">
                        </div>
                        <div class="edit-btn options-add">
                            <button type="submit">条件を追加</button>
                        </div>
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
    </div>
</div>
@endsection
