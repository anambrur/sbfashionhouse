<?php

namespace App\Console\Commands\Mrks;

use Illuminate\Console\Command;
use App\SM\SM;

class FlashCache extends Command {
	/**
	 * Flash Cache.
	 *
	 * @var string
	 */
	protected $signature = 'mrks:flashCache {force=notForced}';

	/**
	 * Flash mrk sohag defined cache.
	 *
	 * @var string
	 */
	protected $description = 'Flash MRKS defined cache.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
		$confirmFlash = $this->argument( 'force' ) == 'f' ? true : false;
		if (! $confirmFlash ) {
			$confirmFlash = $this->confirm( "Are you sure to flash MRKS Cache file?" );
		}
		if ( $confirmFlash ) {
			if ( SM::hasCache() ) {
				if ( SM::flashCache() ) {
					$this->info( "All MRKS Cache Deleted Successfully!" );
				} else {
					$this->error( 'MRKS Cache file Delete Failed!' );
				}
			} else {
				$this->warn( "No Cache found!" );
			}
		} else {
			$this->warn( 'MRKS Cache File Delete Failed!' );
		}
	}
}
