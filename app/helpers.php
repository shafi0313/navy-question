<?php

use Carbon\Carbon;
use Illuminate\Http\Request;

if (!function_exists('devAdminEmail')) {
    function devAdminEmail()
    {
        return 'dev.admin@shafi95.com';
    }
}

if(!function_exists('bdDate')){
    function bdDate($date){
        return Carbon::parse($date)->format('d/m/Y');
    }
}

if(!function_exists('examDateTime')){
    function examDateTime($date){
        return Carbon::parse($date)->format('d/m/Y g:i A');
    }
}

if(!function_exists('permissionText')){
    function permissionText($permission){
        switch($permission){
            case 0;
                $permission = 'No Login Permission';
                break;
            case 1;
                $permission = 'Admin';
                break;
            case 2;
                $permission = 'Creator';
                break;
            case 3;
                $permission = 'Editor';
                break;
            case 4;
                $permission = 'Viewer';
                break;
        }
        return $permission;
    }
}

if(!function_exists('profileImg')){
    function profileImg($email='', $image=''){
        if ($email == devAdminEmail()){
            $profileImg =  asset('uploads/images/users/shafi.jpg');
        }else if($image == null){
            $profileImg =  asset('uploads/images/users/company_logo.jpg');
        }else{
            $profileImg =  asset('uploads/images/users/'.$image);
        }
        return $profileImg;
    }
}

if(!function_exists('ageWithDays')){
    function ageWithDays($d_o_b){
        return Carbon::parse($d_o_b)->diff(Carbon::now())->format('%y years, %m months and %d days');
    }
}
if(!function_exists('ageWithMonths')){
    function ageWithMonths($d_o_b){
        return Carbon::parse($d_o_b)->diff(Carbon::now())->format('%y years, %m months');
    }
}

if (!function_exists('readableSize')) {
    function readableSize($bytes)
    {
        $units = ['B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB'];
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }
}

if (!function_exists('activeSubNav')) {
    function activeSubNav($route)
    {
        if (is_array($route)) {
            $rt = '';
            foreach ($route as $rut) {
                $rt .= request()->routeIs($rut) || '';
            }
            return $rt ? ' activeSub ' : '';
        }
        return request()->routeIs($route) ? ' activeSub ' : '';
    }
}

if (!function_exists('activeNav')) {
    function activeNav($route)
    {
        if (is_array($route)) {
            $rt = '';
            foreach ($route as $rut) {
                $rt .= request()->routeIs($rut) || '';
            }
            return $rt ? ' active ' : '';
        }
        return request()->routeIs($route) ? ' active ' : '';
    }
}

if (!function_exists('openNav')) {
    function openNav(array $routes)
    {
        $rt = '';
        foreach ($routes as $route) {
            $rt .= request()->routeIs($route) || '';
        }
        return $rt ? ' show ' : '';
    }
}

