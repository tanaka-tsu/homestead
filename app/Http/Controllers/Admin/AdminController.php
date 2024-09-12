<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Models\Kintai;
use App\Models\Location;
use App\Models\Condition;
use Carbon\Carbon;

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
        $users_list = User::latest()->paginate(20);
        $locations = Location::all();
        $conditions = Condition::all();
        return view('admin.index', compact('users_list', 'locations', 'conditions'));
    }

    public function show($id) {
        $admin = $this->findAdminOrFail($id);
        $admins = Admin::latest()->get();
        return view('admin.show', compact('id', 'admin', 'admins'));
    }

    public function edit($id) {
        $admin = $this->findAdminOrFail($id);
        return view('admin.edit', compact('admin', 'id'));
    }

    public function update(Request $request, $id) {
        $admin = $this->findAdminOrFail($id);
        $request->validate([
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('admins')->ignore($id)],
            'admin_id' => 'required',
        ],[
            'name.required' => '名前が入力されていません。',
            'email.required' => 'メールアドレスが入力されていません。',
            'admin_id.required' => '管理者IDが入力されていません。',
        ]);

        $admin->update($request->only(['name', 'email', 'admin_id']));
        return redirect()->route('admin.show', $id);
    }

    public function passwordForm($id) {
        $admin = $this->findAdminOrFail($id);
        return view('admin.change_pass', compact('admin', 'id'));
    }

    public function changePassword(Request $request, $id) {
        $admin = $this->findAdminOrFail($id);
        $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->get('current-password'), $admin->password)) {
            return redirect()->route('admin.pass_form', $id)
                ->withInput()
                ->withErrors(['current-password' => '現在のパスワードと一致しません。']);
        }
        if ($request->get('current-password') === $request->get('new-password')) {
            return redirect()->route('admin.pass_form', $id)
                ->withInput()
                ->withErrors(['new-password' => '同じパスワードは登録できません。']);
        }

        $admin->update(['password' => Hash::make($request->get('new-password'))]);

        return redirect()->route('admin.show', $id)
            ->with('flash_message', 'パスワードを変更しました。');
    }

    public function search(Request $request) {
        $locations = Location::all();
        $conditions = Condition::orderBy('detail', 'asc')->get();

        $month_input = $request->input('month');
        $month = Carbon::parse($month_input)->format('Y-m');
        $query = Kintai::query();

        // 年月が指定されている場合（必須）
        if ($request->filled('month')) {
            $query->where('this_month', 'LIKE', "{$month}%");

            // 所属と勤務条件が未選択の場合
            if ($request->input('office') === '未選択' && $request->input('terms') === '未選択') {
                $results = $query->get();
            }

            // 所属が指定されていて、勤務条件が未選択の場合
            if ($request->filled('office') && $request->input('office') !== '未選択' && $request->input('terms') === '未選択') {
                $query->whereHas('user', function($q) use ($request) {
                    $q->where('office', $request->input('office'));
                });
                $results = $query->get();
            }

            // 勤務条件が指定されていて、所属が未選択の場合
            if ($request->filled('terms') && $request->input('terms') !== '未選択' && $request->input('office') === '未選択') {
                $query->whereHas('user', function($q) use ($request) {
                    $q->where('terms', $request->input('terms'));
                });
                $results = $query->get();
            }

            // 所属と勤務条件が両方指定されている場合
            if ($request->filled('office') && $request->input('office') !== '未選択' && $request->filled('terms') && $request->input('terms') !== '未選択') {
                $query->whereHas('user', function($q) use ($request) {
                    $q->where('office', $request->input('office'))
                    ->where('terms', $request->input('terms'));
                });
                $results = $query->get();
            }
        }

        $results = $query->orderBy('this_month', 'asc')->paginate(20);
        $message = $results->isEmpty() ? '該当するデータがありません。' : '';
        session()->flashInput($request->all());

        return view('admin.search', compact('locations', 'conditions', 'results', 'message'));
    }
}
