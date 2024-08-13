<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kintai;
use App\Http\Requests\KintaiRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KintaiController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index() {
        return view('kintais.create');
    }

    public function store(KintaiRequest $request) {
        $request->validate([
            'date' => 'required',
        ]);
        $user = Auth::user();
        $id = Auth::id();
        $today = Carbon::now()->format('d');
        $columnName = 'work_start_' . $today;

        $kintai = new Kintai();
        $kintai->user_id = $user->id;
        $kintai->date = $request->date;
        $kintai->$columnName = Carbon::now()->format('H:i:s');
        $kintai->save();

        return redirect()->route('create.kintais');
    }


}
