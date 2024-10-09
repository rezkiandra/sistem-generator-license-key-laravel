<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\License;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Dokumentasi API",
 *      description="API Documentation",
 *      @OA\Contact(
 *          email="rezkiandra4123@gmail.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 *
 * @OA\Server(
 *      url=MY_SERVER,
 *      description="Demo API Server"
 * )
 */

class ApiLicenseController extends Controller
{
	protected $urlApi;

	public function __construct()
	{
		$this->urlApi = config('app.url');
	}

	/**
	 * @OA\Get(
	 *     path="/api/license",
	 *     tags={"Licenses"},
	 *     summary="Get list of licenses",
	 *     description="Returns list of licenses",
	 *     @OA\Response(
	 *         response=200,
	 *         description="Licenses retrieved successfully"
	 *     ),
	 *     @OA\Response(
	 *         response=404,
	 *         description="Licenses not found")
	 * 		 ),
	 * )
	 **/

	public function index()
	{
		try {
			$licenses = License::all();

			if ($licenses) {
				return response()->json([
					'status_code' => 200,
					'success' => true,
					'url' => $this->urlApi . '/api/license',
					'message' => 'Licenses retrieved successfully.',
					'licenses' => $licenses,
				]);
			} else {
				return response()->json([
					'status_code' => 404,
					'success' => false,
					'message' => 'Licenses not found.',
				], 404);
			}
		} catch (Exception $e) {
			return response()->json([
				'status_code' => 500,
				'success' => false,
				'message' => $e->getMessage(),
			], 500);
		}
	}

	/**
	 * @OA\Get(
	 *     path="/api/license/edit/{license}",
	 *     tags={"Licenses"},
	 *     summary="Edit license by key",
	 *     description="Returns license",
	 *     @OA\Parameter(
	 *         name="key",
	 *         in="path",
	 *         required=true,
	 *         description="License key",
	 *         @OA\Schema(
	 *             type="string"
	 *         ),
	 *     ),
	 *     @OA\Response(
	 * 			response=200,
	 * 			description="License retrieved successfully"
	 * 		),
	 * 
	 *     @OA\Response(
	 *         response=404,
	 *         description="License not found")
	 * 		 ),
	 *     @OA\Response(
	 *         response=500,
	 *         description="Server error"
	 *     ),
	 * )
	 **/

	public function edit(string $key)
	{
		try {
			$license = License::where('key', $key)->first();

			if ($license) {
				return response()->json([
					'status_code' => 200,
					'success' => true,
					'url' => $this->urlApi . '/api/license/edit/' . $key,
					'message' => 'License retrieved successfully.',
					'license' => $license,
				]);
			} else {
				return response()->json(
					[
						'status_code' => 404,
						'success' => false,
						'message' => 'License not found.',
					],
					404,
				);
			}
		} catch (Exception $e) {
			return response()->json(
				[
					'status_code' => 500,
					'success' => false,
					'message' => $e->getMessage(),
				],
				500,
			);
		}
	}

	/**
	 * @OA\Post(
	 *     path="/api/license/generate",
	 *     tags={"Licenses"},
	 *     summary="Generate new license",
	 *     description="Returns license",
	 *     @OA\RequestBody(
	 *         @OA\MediaType(
	 *             mediaType="application/json",
	 *             @OA\Schema(
	 *                 @OA\Property(
	 *                     property="license_name",
	 *                     type="string"
	 *                 ),
	 *                 @OA\Property(
	 *                     property="duration_day",
	 *                     type="integer"
	 *                 ),
	 *                 example={
	 *                     "license_name": "My License",
	 *                     "duration_day": 30
	 *                 }
	 *             )
	 *         )
	 *     ),
	 *     @OA\Response(
	 *         response=200,
	 *         description="License generated successfully"
	 *     ),
	 *     @OA\Response(
	 *         response=400,
	 *         description="Validation error"
	 *     ),
	 *     @OA\Response(
	 *         response=500,
	 *         description="Server error"
	 *     )
	 * )
	 **/


	public function generate(Request $request)
	{
		try {
			$validated = Validator::make($request->all(), [
				'license_name' => 'required|unique:licenses,license_name|string|min:4',
				'duration_day' => 'required|numeric|min:1',
			]);

			if ($validated->fails()) {
				return response()->json(
					[
						'status_code' => 400,
						'success' => false,
						'message' => $validated->errors(),
					],
					400,
				);
			} else {
				$license = new License();
				$license->key = Str::random();
				$license->license_name = $request->license_name;
				$license->duration_day = $request->duration_day;
				$license->expired_at = Carbon::now()->addDays((int) $request->duration_day);
				$license->save();

				return response()->json([
					'status_code' => 200,
					'success' => true,
					'url' => $this->urlApi . '/api/license/generate/' . $license->key,
					'message' => 'License generated successfully.',
					'license' => $license,
				]);
			}
		} catch (Exception $e) {
			return response()->json(
				[
					'status_code' => 500,
					'success' => false,
					'message' => $e->getMessage(),
				],
				500,
			);
		}
	}

	/**
	 * @OA\Put(
	 *     path="/api/license/update/{license}",
	 *     tags={"Licenses"},
	 *     summary="Update license by key",
	 *     description="Returns license",
	 *     @OA\Parameter(
	 *         name="license",
	 *         in="path",
	 *         required=true,
	 *         description="License key",
	 *         @OA\Schema(
	 *             type="string"
	 *         )
	 *     ),
	 *     @OA\RequestBody(
	 *         @OA\MediaType(
	 *             mediaType="application/json",
	 *             @OA\Schema(
	 *                 @OA\Property(
	 *                     property="license_name",
	 *                     type="string"
	 *                 ),
	 *                 @OA\Property(
	 *                     property="domain_name",
	 *                     type="string"
	 *                 ),
	 *                 @OA\Property(
	 *                     property="duration_day",
	 *                     type="integer"
	 *                 ),
	 *                 @OA\Property(
	 *                     property="is_active",
	 *                     type="integer"
	 *                 ),
	 *                 example={
	 *                     "license_name": "My License",
	 *                     "domain_name": "example.com",
	 *                     "duration_day": 30,
	 *                     "is_active": 1
	 *                 }
	 *             )
	 *         )
	 *     ),
	 *     @OA\Response(
	 *         response=200,
	 *         description="License updated successfully"
	 *     ),
	 *     @OA\Response(
	 *         response=400,
	 *         description="Validation error"
	 *     ),
	 *     @OA\Response(
	 *         response=500,
	 *         description="Server error"
	 *     )
	 * )
	 **/

	public function update(Request $request, string $key)
	{
		try {
			$validated = Validator::make($request->all(), [
				'license_name' => 'required|string|min:4',
				'domain_name' => 'nullable|required_if:is_active,1|url',
				'duration_day' => 'required|numeric|min:1',
				'is_active' => 'required_if:domain_name,not_null|in:0,1',
			]);

			if ($validated->fails()) {
				return response()->json([
					'status_code' => 400,
					'success' => false,
					'message' => $validated->errors(),
				], 400);
			} else {
				$license = License::where('key', $key)->first();

				if ($license) {
					$license->license_name = $request->license_name;
					$license->domain_name = $request->domain_name;
					$license->duration_day = $request->duration_day;
					$license->is_active = $request->is_active;
					$license->expired_at = Carbon::now()->addDays((int) $request->duration_day);

					if ($license->is_active == 1 && Str::isUuid($license->key) == false) {
						$license->key = Str::uuid();
					} elseif (!$license->key || $license->is_active == 0) {
						$license->key = Str::random();
						$license->domain_name = null;
					}

					$license->update();

					return response()->json([
						'status_code' => 200,
						'success' => true,
						'url' => $this->urlApi . '/api/license/update/' . $key,
						'message' => 'License updated successfully.',
						'license' => $license,
					]);
				} else {
					return response()->json([
						'status_code' => 404,
						'success' => false,
						'message' => 'License not found.',
					], 404);
				}
			}
		} catch (Exception $e) {
			return response()->json([
				'status_code' => 500,
				'success' => false,
				'message' => $e->getMessage(),
			], 500);
		}
	}

	/**
	 * @OA\Delete(
	 *     path="/api/license/destroy/{license}",
	 *     tags={"Licenses"},
	 *     summary="Delete license by key",
	 *     description="Returns license",
	 *     @OA\Parameter(
	 *         name="license",
	 *         in="path",
	 *         required=true,
	 *         description="License key",
	 *         @OA\Schema(
	 *             type="string"
	 *         )
	 *     ),
	 *     @OA\Response(
	 *         response=200,
	 *         description="License deleted successfully"
	 *     ),
	 *     @OA\Response(
	 *         response=404,
	 *         description="License not found"
	 *     ),
	 *     @OA\Response(
	 *         response=500,
	 *         description="Server error"
	 *     )
	 * )
	 **/

	public function destroy(string $key)
	{
		try {
			$license = License::where('key', $key)->first();

			if ($license) {
				$license->delete();
				return response()->json([
					'status_code' => 200,
					'success' => true,
					'url' => $this->urlApi . '/api/license/destroy/' . $key,
					'message' => 'License deleted successfully.',
				]);
			} else {
				return response()->json(
					[
						'status_code' => 404,
						'success' => false,
						'message' => 'License not found.',
					],
					404,
				);
			}
		} catch (Exception $e) {
			return response()->json(
				[
					'status_code' => 500,
					'success' => false,
					'message' => $e->getMessage(),
				],
				500,
			);
		}
	}
}
