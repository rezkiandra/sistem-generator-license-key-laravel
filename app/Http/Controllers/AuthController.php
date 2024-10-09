<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
	public function login()
	{
		return view('auth.login');
	}

	public function loginAction(Request $request)
	{
		$credentials = $request->validate([
			'email' => ['required', 'email', 'exists:users,email'],
			'password' => ['required'],
		], [
			'email.required' => 'Email is required',
			'email.email' => 'Email is not valid',
			'email.exists' => 'Email is not registered',

			'password.required' => 'Password is required',
		], [
			'email' => 'Email',
			'password' => 'Password',
		]);

		if (Auth::attempt($credentials)) {
			$request->session()->regenerate();
			return redirect()->route('admin.licenses')->with('success', 'Login successfully');
		}

		return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
	}

	public function logout(Request $request)
	{
		try {
			Auth::logout();

			$request->session()->invalidate();
			$request->session()->regenerateToken();

			return redirect()->route('login')->with('success', 'Logout successfully');
		} catch (Exception $e) {
			return redirect()->back()->withErrors($e->getMessage());
		}
	}
}
