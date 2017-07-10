<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{

    /**
     * SettingController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('user.setting');
    }

    public function store(Request $request)
    {
        user()->settings()->merge($request->all());

        return back();
    }
}
