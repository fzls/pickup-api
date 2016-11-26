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
        $regex_id = '[0-9]+';
        $regex_numeric = '[0-9\.]+';
        \Route::pattern('chat', $regex_id);
        \Route::pattern('gift', $regex_id);
        \Route::pattern('history', $regex_id);
        \Route::pattern('location', $regex_id);
        \Route::pattern('notification', $regex_id);
        \Route::pattern('pal', $regex_id);
        \Route::pattern('user', $regex_id);
        \Route::pattern('vehicle', $regex_id);
        \Route::pattern('recharge', $regex_id);
        \Route::pattern('withdraw', $regex_id);
        \Route::pattern('payment', $regex_id);
        \Route::pattern('revenue', $regex_id);

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
