<?php

namespace PickupApi\Providers;

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
    protected $namespace = 'PickupApi\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot() {
        /*路由参数的一些限制条件*/
        \Route::pattern('chat', '[0-9]+');
        \Route::pattern('gift', '[0-9]+');
        \Route::pattern('history', '[0-9]+');
        \Route::pattern('location', '[0-9]+');
        \Route::pattern('notification', '[0-9]+');
        \Route::pattern('pal', '[0-9]+');
        \Route::pattern('to', '[0-9]+');
        \Route::pattern('user', '[0-9]+');
        \Route::pattern('vehicle', '[0-9]+');
        \Route::pattern('recharge_amount', '[0-9]+');
        \Route::pattern('withdraw_amount', '[0-9]+');
        \Route::pattern('amount', '[0-9\.]+');

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map() {
        /*TODO: 此处可以用于api分版本注册*/
        $this->mapApiV1Routes();

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
        Route::group([
                         'middleware' => 'web',
                         'namespace'  => $this->namespace,
                     ], function ($router) {
            require base_path('routes/web.php');
        });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiV1Routes() {
        Route::group([
                         'middleware' => 'api',
                         'namespace'  => $this->namespace,
                         'prefix'     => 'api/v1',
                     ], function ($router) {
            require base_path('routes/api_v1.php');
        });
    }
}
