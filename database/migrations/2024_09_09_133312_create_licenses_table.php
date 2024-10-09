<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('licenses', function (Blueprint $table) {
			$table->id();
			$table->uuid('key')->nullable();
			$table->string('license_name', 100)->nullable();
			$table->string('domain_name')->nullable();
			$table->integer('duration_day')->nullable();
			$table->enum('is_active', [0, 1])->default(0);
			$table->timestamp('expired_at')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('licenses');
	}
};
