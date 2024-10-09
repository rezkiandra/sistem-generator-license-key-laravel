<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\License;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class UpdateExpireLicenses extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'app:update-expire-licenses';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Update status and key for expired licenses';

	/**
	 * Execute the console command.
	 */

	public function __construct()
	{
		parent::__construct();
	}

	public function handle()
	{
		$licenses = License::where('expired_at', '<', Carbon::now())->get();

		foreach ($licenses as $license) {
			$license->key = Str::uuid();
			$license->is_active = 0;

			$license->save();
		}

		$this->info('Expired licenses have been updated');
	}
}
