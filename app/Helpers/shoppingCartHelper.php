<?php

/**
 * Get an item from an array using "dot" notation.
 *  shopping card package uses laravel 5.8 so i write this to avoid errors on laravel 6
 * @param  \ArrayAccess|array $array
 * @param  string|int|null $key
 * @param  mixed $default
 * @return mixed
 */
if (!function_exists('array_get')){
    function array_get($array, $key, $default){
        return \Illuminate\Support\Arr::get($array, $key, $default);
    }
}