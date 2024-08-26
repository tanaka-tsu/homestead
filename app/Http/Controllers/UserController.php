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

    private function findUserOrFail($id) {
        if ($id != Auth::id()) { abort(404); }
        return User::findOrFail($id);
    }

    public function show($id) {
        $user = $this->findUserOrFail($id);
        return view('user.show', compact('user', 'id'));
    }

    public function edit($id) {
        $user = $this->findUserOrFail($id);
        return view('user.edit', compact('user', 'id'));
    }

    public function update(Request $request, $id) {
        $user = $this->findUserOrFail($id);
        $request->validate([
            'employee_id' => 'required',
            'office' => 'required',
            'name' => 'required',
            'terms' => 'required',
            'email' => 'required',
        ],[
            'employee_id.required' => '社員番号が入力されていません。',
            'office.required' => '所属が選択されていません。',
            'name.required' => '名前が入力されていません。',
            'terms.required' => '条件が選択されていません。',
            'email.required' => 'メールアドレスが入力されていません。',
        ]);

        $user->update($request->only(['employee_id', 'office', 'name', 'terms', 'email']));
        return redirect()->route('show.user', $user->id);
    }

    public function passwordForm($id) {
        $user = $this->findUserOrFail($id);
        return view('user.change', compact('user', 'id'));
    }

    public function changePassword(Request $request, $id) {
        $user = $this->findUserOrFail($id);

        if (!Hash::check($request->get('current-password'), $user->password)) {
            return redirect()->route('passwordForm.user', $user->id)
                ->withInput()
                ->withErrors(['current-password' => '現在のパスワードと一致しません。']);
        }

        if ($request->get('current-password') === $request->get('new-password')) {
            return redirect()->route('passwordForm.user', $user->id)
                ->withInput()
                ->withErrors(['new-password' => '同じパスワードは登録できません。']);
        }

        $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|confirmed',
        ]);

        $user->update(['password' => Hash::make($request->get('new-password'))]);
        return redirect()->route('show.user', $user->id)
            ->with('flash_message', 'パスワードを変更しました。');
    }
}
