<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;

class AdminController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin');
    }

    private function findAdminOrFail($id) {
        if ($id != Auth::id()) { abort(404); }
        return Admin::findOrFail($id);
    }

    public function index() {
        $users = User::latest()->paginate(5);
        $admins = Admin::latest()->get();
        return view('admin.index', compact('users', 'admins'));
    }

    public function show($id) {
        $admin = $this->findAdminOrFail($id);
        return view('admin.show', compact('admin', 'id'));
    }

    public function edit($id) {
        $admin = $this->findAdminOrFail($id);
        return view('admin.edit', compact('admin', 'id'));
    }

    public function update(Request $request, $id) {
        $admin = $this->findAdminOrFail($id);
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'admin_id' => 'required',
        ],[
            'name.required' => '名前が入力されていません。',
            'email.required' => 'メールアドレスが入力されていません。',
            'admin_id.required' => '管理者IDが入力されていません。',
        ]);

        $admin->update($request->only(['name', 'email', 'admin_id']));
        return redirect()->route('show.admin', $id);
    }

    public function passwordForm($id) {
        $admin = $this->findAdminOrFail($id);
        return view('admin.change', compact('admin', 'id'));
    }

    public function changePassword(Request $request, $id) {
        $admin = $this->findAdminOrFail($id);

        if (!Hash::check($request->get('current-password'), $admin->password)) {
            return redirect()->route('passwordForm.admin', $id)
                ->withInput()
                ->withErrors(['current-password' => '現在のパスワードと一致しません。']);
        }

        if ($request->get('current-password') === $request->get('new-password')) {
            return redirect()->route('passwordForm.admin', $id)
                ->withInput()
                ->withErrors(['new-password' => '同じパスワードは登録できません。']);
        }

        $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|confirmed',
        ]);

        $admin->update(['password' => Hash::make($request->get('new-password'))]);
        return redirect()->route('show.admin', $id)
            ->with('flash_message', 'パスワードを変更しました。');
    }
}
