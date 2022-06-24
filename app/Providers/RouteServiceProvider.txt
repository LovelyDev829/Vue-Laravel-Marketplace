<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
	/**
	 * This namespace is applied to your controller routes.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	// protected $namespace = 'App\Http\Controllers';

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @return void
	 */
	public function boot()
	{
		//

		parent::boot();
	}

	/**
	 * Define the routes for the application.
	 *
	 * @return void
	 */
	public function map()
	{

		//$this->mapInstallRoutes();

    	//$this->mapUpdateRoutes();

		$this->mapApiRoutes();

		$this->mapAdminRoutes();

		$this->mapSellerRoutes();

		$this->mapRefundRoutes();

		$this->mapWebRoutes();
	}

	/**
	 * Define the "installation" routes for the application.
	 *
	 * These routes all receive session state, CSRF protection, etc.
	 *
	 * @return void
	 */
	protected function mapInstallRoutes()
	{
		Route::middleware('web')
			->group(base_path('routes/install.php'));
	}

	protected function mapUpdateRoutes()
	{
	    Route::middleware('web')
	       ->group(base_path('routes/update.php'));
	}

	/**
	 * Define the "web" routes for the application.
	 *
	 * These routes all receive session state, CSRF protection, etc.
	 *
	 * @return void
	 */
	protected function mapWebRoutes()
	{
		Route::middleware('web')
			->group(base_path('routes/web.php'));
	}

	/**
	 * Define the "admin" routes for the application.
	 *
	 * These routes all receive session state, CSRF protection, etc.
	 *
	 * @return void
	 */
	protected function mapAdminRoutes()
	{
		Route::middleware('web')
			->group(base_path('routes/admin.php'));
	}

	protected function mapSellerRoutes()
	{
		Route::middleware('web')
			->group(base_path('routes/seller.php'));
	}

	protected function mapRefundRoutes()
	{
		Route::middleware('web')
			->group(base_path('routes/refund.php'));
	}

	/**
	 * Define the "api" routes for the application.
	 *
	 * These routes are typically stateless.
	 *
	 * @return void
	 */
	protected function mapApiRoutes()
	{
		Route::prefix('api')
			->middleware('api')
			->group(base_path('routes/api.php'));
	}
}
