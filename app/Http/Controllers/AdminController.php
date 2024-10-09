<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
	protected $urlApi;

	public function __construct()
	{
		$this->urlApi = config('app.url');
	}

	public function licenses()
	{
		try {
			$response = Http::get($this->urlApi . '/api/license');

			if ($response->successful()) {
				$data = $response->json();
				return view('license.index', compact('data'));
			} else {
				throw new Exception($response->json('message'));
			}
		} catch (Exception $e) {
			return redirect()->back()->with('error', $e->getMessage());
		}
	}

	public function api_consume()
	{
		try {
			$response = Http::get($this->urlApi . '/api/license');

			if ($response->successful()) {
				$data = $response->json();
				return view('admin.api_consume', compact('data'));
			} else {
				throw new Exception($response->json('message'));
			}
		} catch (Exception $e) {
			return redirect()->back()->with('error', $e->getMessage());
		}
	}

	public function profile()
	{
		return view('admin.profile');
	}
}
