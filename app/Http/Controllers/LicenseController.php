<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class LicenseController extends Controller
{
	protected $urlApi;

	public function __construct()
	{
		$this->urlApi = config('app.url');
	}

	public function create()
	{
		return view('license.create');
	}

	public function edit(string $key)
	{
		try {
			$response = Http::get($this->urlApi . '/api/license/edit/' . $key);

			if ($response->json('status_code') == 200 && $response->json('success') == true) {
				return view('license.edit', compact('response'));
			} else {
				return redirect()->route('admin.licenses')->with('error', $response->json('message'));
			}
		} catch (Exception $e) {
			return redirect()->route('admin.licenses')->with('error', $e->getMessage());
		}
	}

	public function generate(Request $request)
	{
		try {
			$response = Http::withHeaders([
				'Accept' => 'application/json',
				'Content-Type' => 'application/json',
			])->post($this->urlApi . '/api/license/generate', [
				'key' => Str::random(),
				'license_name' => $request->license_name,
				'duration_day' => $request->duration_day,
				'expired_at' => Carbon::now()->addDays((int)$request->duration_day),
			]);

			if ($response->json('status_code') == 200 && $response->json('success') == true) {
				return redirect()->route('admin.licenses')->with('success', $response->json('message'));
			} else {
				return redirect()->back()->withInput()->withErrors($response->json('message'));
			}
		} catch (Exception $e) {
			return response()->json([
				'status_code' => 500,
				'success' => false,
				'message' => $e->getMessage(),
			], 500);
		}
	}

	public function update(Request $request, string $key)
	{
		try {
			$response = Http::put($this->urlApi . '/api/license/update/' . $key, [
				'key' => $key,
				'license_name' => $request->license_name,
				'domain_name' => $request->domain_name,
				'duration_day' => $request->duration_day,
				'is_active' => $request->is_active,
				'expired_at' => Carbon::now()->addDays((int)$request->duration_day),
			]);

			if ($response->json('status_code') == 200 && $response->json('success') == true) {
				return redirect()->route('admin.licenses')->with('success', $response->json('message'));
			} else {
				return redirect()->back()->withInput()->withErrors($response->json('message'));
			}
		} catch (Exception $e) {
			return response()->json([
				'status_code' => 500,
				'success' => false,
				'message' => $e->getMessage(),
			], 500);
		}
	}

	public function destroy(string $key)
	{
		try {
			$response = Http::delete('' . $this->urlApi . '/api/license/destroy/' . $key);

			if ($response->json('status_code') == 200 && $response->json('success') == true) {
				return redirect()->route('admin.licenses')->with('success', $response->json('message'));
			} else {
				return response()->json([
					'status_code' => 500,
					'success' => false,
					'message' => 'License not found.',
				], 500);
			}
		} catch (Exception $e) {
			return response()->json([
				'status_code' => 500,
				'success' => false,
				'message' => $e->getMessage(),
			], 500);
		}
	}
}
