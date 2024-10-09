<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ApiAuthController extends Controller
{
	public function loginAction(Request $request)
	{
		try {
			$validated = $request->validate([
				'email' => 'required|email|exists:users,email',
				'password' => 'required',
			], [
				'email.required' => 'Email is required',
				'email.email' => 'Email is not valid',
				'email.exists' => 'Email not registered',
				'password.required' => 'Password is required',
			], [
				'email' => 'Email',
				'password' => 'Password',
			]);

			if (Auth::attempt($validated)) {
				return response()->json([
					'status_code' => 200,
					'success' => true,
					'message' => 'Login successfully',
					'data' => [
						'user' => Auth::user(),
					]
				], 200);
			} else {
				return response()->json([
					'status_code' => 400,
					'success' => false,
					'message' => 'Login failed',
				], 400);
			}
		} catch (Exception $e) {
			return response()->json([
				'status_code' => 400,
				'success' => false,
				'message' => $e->getMessage(),
			], 400);
		}
	}

	public function logout()
	{
		try {
			Auth::logout();
			return response()->json([
				'status_code' => 200,
				'success' => true,
				'message' => 'Logout successfully',
			], 200);
		} catch (Exception $e) {
			return response()->json([
				'status_code' => 400,
				'success' => false,
				'message' => $e->getMessage(),
			], 400);
		}
	}
}
