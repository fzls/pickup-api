<?php
/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2016-11-24
 * Time: 17:49
 */

namespace PickupApi\Utils;


class UrlUtil {
    public static function getAllSupportedMethods() {
        $allowed = [];
        $routes    = \Route::getRoutes()->getRoutes();
        foreach ($routes as $route) {
            /* @var $route \Illuminate\Routing\Route */
            if ($route->getUri() === ltrim(\Request::getPathInfo(), '/')) {
                $allowed[] = $route->getMethods();
            }
        }

        return array_collapse($allowed);
    }
}