<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
	use HasFactory;

	protected $fillable = [
		'key',
		'license_name',
		'domain_name',
		'duration_day',
		'is_active',
		'expired_at',
	];
}
