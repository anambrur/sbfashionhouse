<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider {
	/**
	 * This namespace is applied to your controller routes.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'App\Http\Controllers';

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @return void
	 */
	public function boot() {
		//

		parent::boot();
	}

	/**
	 * Define the routes for the application.
	 *
	 * @return void
	 */
	public function map() {
		/**
		 * Engr. Mizanur Rahman Khan Routes
		 */

		$this->mapSmFrontEndRoutes();
		$this->mapSmBackEndRoutes();
		$this->mapSmDebugRoutes();


		/**
		 * default routes
		 */
		$this->mapApiRoutes();

		$this->mapWebRoutes();

		//


	}

	/**
	 * Define the "web" routes for the application.
	 *
	 * These routes all receive session state, CSRF protection, etc.
	 *
	 * @return void
	 */
	protected function mapWebRoutes() {
		Route::middleware( [ "web", "maintenance", "DailyVisitor" ] )
		     ->namespace( $this->namespace )
		     ->group( base_path( 'routes/web.php' ) );
	}

	/**
	 * Engr. Mizanur Rahman Khan Routes
	 */
	protected function mapSmFrontEndRoutes() {
		Route::middleware( [ "web", "maintenance", "DailyVisitor" ] )
		     ->namespace( $this->namespace )
		     ->group( base_path( 'routes/smFrontEndRoutes.php' ) );
	}

	protected function mapSmBackEndRoutes() {
		Route::middleware( [ "web", "maintenance", "DailyVisitor" ] )
		     ->namespace( $this->namespace )
		     ->group( base_path( 'routes/smBackEndRoutes.php' ) );
	}

	protected function mapSmDebugRoutes() {
		Route::middleware( ["web",  "DailyVisitor" ])
		     ->namespace( $this->namespace )
		     ->group( base_path( 'routes/smDebugRoutes.php' ) );
	}

	/**
	 * Define the "api" routes for the application.
	 *
	 * These routes are typically stateless.
	 *
	 * @return void
	 */
	protected function mapApiRoutes() {
		Route::prefix( 'api' )
		     ->middleware( ['api',  "maintenance", "DailyVisitor" ] )
		     ->namespace( $this->namespace )
		     ->group( base_path( 'routes/api.php' ) );
	}
}
