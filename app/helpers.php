<?php
if (!function_exists('full_asset')) {
    function full_asset($path)
    {
        $cleanPath = ltrim($path, '/');
        return request()->getSchemeAndHttpHost() . '/' . $cleanPath;
    }
}