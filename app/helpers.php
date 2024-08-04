<?php

use Carbon\Carbon;
use Illuminate\Http\Request;

if (! function_exists('devAdminEmail')) {
    function devAdminEmail()
    {
        return 'dev.admin@shafi95.com';
    }
}

if (! function_exists('bdDate')) {
    function bdDate($date)
    {
        return Carbon::parse($date)->format('d/m/Y');
    }
}

if (! function_exists('examDateTime')) {
    function examDateTime($date)
    {
        return Carbon::parse($date)->format('d/m/Y g:i A');
    }
}
if (! function_exists('time12')) {
    function time12($date)
    {
        return Carbon::parse($date)->format('g:i A');
    }
}

if (! function_exists('questionSetInBangla')) {
    function questionSetInBangla($set)
    {
        return match ($set) {
            1 => 'লাল',
            2 => 'বাদামি',
            3 => 'হলুদ',
            4 => 'নীল',
            5 => 'বেগুনি',
            6 => 'কাল',
            default => 'N/A',
        };
    }
}

if (! function_exists('permissionText')) {
    function permissionText($permission)
    {
        switch ($permission) {
            case 0:
                $permission = 'No Login Permission';
                break;
            case 1:
                $permission = 'Admin';
                break;
            case 2:
                $permission = 'Creator';
                break;
            case 3:
                $permission = 'Editor';
                break;
            case 4:
                $permission = 'Viewer';
                break;
        }

        return $permission;
    }
}

if (! function_exists('quesSet')) {
    function quesSet($set)
    {
        switch ($set) {
            case 1:
                $set = 'A';
                break;
            case 2:
                $set = 'B';
                break;
            case 3:
                $set = 'C';
                break;
            case 4:
                $set = 'D';
                break;
            case 5:
                $set = 'E';
                break;
        }

        return $set;
    }
}

if (! function_exists('profileImg')) {
    function profileImg($email = '', $image = '')
    {
        if ($email == devAdminEmail()) {
            $profileImg = asset('uploads/images/users/shafi.jpg');
        } elseif ($image == null) {
            $profileImg = asset('uploads/images/users/company_logo.jpg');
        } else {
            $profileImg = asset('uploads/images/users/'.$image);
        }

        return $profileImg;
    }
}

if (! function_exists('ageWithDays')) {
    function ageWithDays($d_o_b)
    {
        return Carbon::parse($d_o_b)->diff(Carbon::now())->format('%y years, %m months and %d days');
    }
}
if (! function_exists('ageWithMonths')) {
    function ageWithMonths($d_o_b)
    {
        return Carbon::parse($d_o_b)->diff(Carbon::now())->format('%y years, %m months');
    }
}

if (! function_exists('readableSize')) {
    function readableSize($bytes)
    {
        $units = ['B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB'];
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2).' '.$units[$i];
    }
}

if (! function_exists('activeSubNav')) {
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

if (! function_exists('activeNav')) {
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

if (! function_exists('openNav')) {
    function openNav(array $routes)
    {
        $rt = '';
        foreach ($routes as $route) {
            $rt .= request()->routeIs($route) || '';
        }

        return $rt ? ' show ' : '';
    }
}
if (! function_exists('user')) {
    function user()
    {
        return auth()->user();
    }
}
if (! function_exists('userCan')) {
    function userCan($permission)
    {
        if (auth()->check() && user()->can($permission)) {
            return true;
        }

        return false;
    }
}
if (! function_exists('imageStore')) {
    function imageStore(Request $request, string $name, string $path)
    {
        if ($request->hasFile('image')) {
            $pathCreate = public_path().$path;
            ! file_exists($pathCreate) ?? File::makeDirectory($pathCreate, 0777, true, true);

            $image = $request->file('image');
            $image_name = $name.uniqueId(20).'.'.$image->getClientOriginalExtension();
            if ($image->isValid()) {
                $request->image->move($path, $image_name);

                return $image_name;
            }
        }
    }
}

if (! function_exists('imageUpdate')) {
    function imageUpdate(Request $request, string $name, string $path, $image)
    {
        if ($request->hasFile('image')) {
            $deletePath = public_path($path.$image);
            file_exists($deletePath) ? unlink($deletePath) : false;

            // $deletePath = public_path().$path.$model->first()->image;
            // $path =  public_path('uploads/images/users/'.$files->image);
            // file_exists($deletePath) ? unlink($deletePath) : false;

            $createPath = public_path().$path;
            ! file_exists($createPath) ?? File::makeDirectory($createPath, 0777, true, true);

            $image = $request->file('image');
            $image_name = $name.uniqueId(20).'.'.$image->getClientOriginalExtension();
            if ($image->isValid()) {
                $request->image->move($path, $image_name);

                return $image_name;
            }
        }
    }
}
