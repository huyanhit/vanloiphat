<?php

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLogin extends Controller
{
    public function index(){
        return view('Admin::Layouts.login');
    }

    public function store(Request $request){
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
   
        if (Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password'), 'role' => 1], true)) {
            $request->session()->regenerate();
            return redirect()->route('pages.index');
        }
    }
}
