<?php

if (!function_exists('array_get')){
    function array_get($a,$b,$c){
       return \Illuminate\Support\Arr::get($a,$b,$c);
    }
}