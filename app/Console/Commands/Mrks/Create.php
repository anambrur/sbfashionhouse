<?php

namespace App\Console\Commands\Mrks;

use App\SM\SM;
use Illuminate\Console\Command;

class Create extends Command {
	/**
	 * Will create new post type.
	 *
	 * @var string
	 */
	protected $signature = 'mrks:create {mrksName}';

	/**
	 * This command will create new controller, model, migration and views for you.
	 *
	 * @var string
	 */
	protected $description = 'Command description';

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
		$mrksName = $this->argument( 'mrksName' );
		if ( ! $mrksName ) {
			$mrksName = $this->ask( "Please provide name.." );
		}
//		$mrksOptions = $this->option( 'mrksOptions' );
		if ( $mrksName ) {
			$data = SM::createPostType( $mrksName, '' );
			if ( $data['migration'] ) {
				$this->info( 'Migration created successfully!' );
			} else {
				$this->warn( 'Migration create failed!' );
			}
			if ( $data['model'] ) {
				$this->info( 'Model created successfully!' );
			} else {
				$this->warn( 'Model create failed!' );
			}
			if ( $data['controller'] ) {
				$this->info( 'Controller created successfully!' );
			} else {
				$this->warn( 'Controller create failed!' );
			}
			$this->info( 'Process Completed' );
		} else {
			$this->error( 'No Name Found' );
		}
	}
}
