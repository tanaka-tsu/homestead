<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::ADMIN_HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function showAdminLoginForm()
    {
        return view('admin.login', ['authgroup' => 'admin']);
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'admin_id'   => 'required',
            'password' => 'required|min:8'
        ],[
            'admin_id.required' => '管理者IDは必須です。',
            'password.required' => 'パスワードは必須です。',
        ]);

        // hasTooManyLoginAttempts メソッドが存在し、かつログイン試行回数が多すぎる場合、ロックアウトイベントを発生させます。
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if (Auth::guard('admin')->attempt(['admin_id' => $request->admin_id, 'password' => $request->password], $request->get('remember'))) {
            return redirect()->intended(route('index.admin'));
        }

        $this->incrementLoginAttempts($request);

        return back()->withInput($request->only('admin_id', 'remember'));
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('login.admin'));
    }
}
