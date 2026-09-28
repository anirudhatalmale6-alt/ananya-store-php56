<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Read a checkbox / boolean input.
     *
     * Laravel 5.5+ has Request::boolean(); Laravel 5.4 does not, so this
     * helper provides the same behaviour.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string                   $key
     * @param  bool                     $default
     * @return bool
     */
    protected function boolInput(Request $request, $key, $default = false)
    {
        if (! $request->has($key)) {
            return $default;
        }

        return filter_var($request->input($key), FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Read a value from an array with a fallback.
     *
     * Stands in for the ?? operator, which is PHP 7.0+.
     *
     * @param  array  $array
     * @param  string $key
     * @param  mixed  $default
     * @return mixed
     */
    protected function arrGet($array, $key, $default = null)
    {
        if (is_array($array) && array_key_exists($key, $array) && $array[$key] !== null) {
            return $array[$key];
        }

        return $default;
    }
}
