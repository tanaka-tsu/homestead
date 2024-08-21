<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
     }

    public function index($id) {
        $user = User::findOrFail($id);

        return view('user.index')->with(['user' => $user, 'id' => $id]);
    }

    public function edit($id) {
        $user = User::findOrFail($id);

        return view('user.edit')->with(['user' => $user, 'id' => $id]);
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'employee_number' => 'required',
            'branch_office' => 'required',
            'name' => 'required',
            'terms' => 'required',
            'email' => 'required',
        ],[
            'employee_number.required' => '社員番号が入力されていません。',
            'branch_office.required' => '所属が選択されていません。',
            'name.required' => '名前が入力されていません。',
            'terms.required' => '条件が選択されていません。',
            'email.required' => 'メールアドレスが入力されていません。',
        ]);

        $user = User::findOrFail($id);
        $user->employee_number = $request->employee_number;
        $user->branch_office = $request->branch_office;
        $user->name = $request->name;
        $user->terms = $request->terms;
        $user->email = $request->email;

        $user->save();

        return redirect()->route('index.user', $user->id);
    }

    public function passwordForm($id) {
        $user = User::findOrFail($id);

        return view('user.change')->with(['user' => $user, 'id' => $id]);
    }

    public function changePassword(Request $request, $id) {
        $user = User::findOrFail($id);
        //現在のパスワードが合っているか調べる
        if(!(Hash::check($request->get('current-password'), $user->password))) {
            return redirect()
                ->route('passwordForm.user', $user->id)
                ->withInput()
                ->withErrors(array('current-password' => '現在のパスワードと一致しません。'));
        }

        //現在のパスワードと新しいパスワードが一致していないか調べる
        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            return redirect()
                ->route('passwordForm.user', $user->id)
                ->withInput()
                ->withErrors(array('new-password' => '同じパスワードは登録できません。'));
        }

        //パスワードのバリデーション
        $validated_date = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|confirmed',
        ]);

        $user->password = Hash::make($request->get('new-password'));
        $user->save();

        return redirect()->route('index.user', $user->id)
            ->with('flash_message', 'パスワードを変更しました');
    }
}
