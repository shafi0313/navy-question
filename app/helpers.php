<?php

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;


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

if (! function_exists('nu')) {
    function nu($set)
    {
        return match ($set) {

            0 => '০',
            1 => '১',
            2 => '২',
            3 => '৩',
            4 => '৪',
            5 => '৫',
            6 => '৬',
            7 => '৭',
            8 => '৮',
            9 => '৯',
            default => 'N/A',
        };
    }
}

if (! function_exists('numberToBanglaWord')) {
    function numberToBanglaWord($set)
    {
        return match ($set) {
            1 => 'ক',
            2 => 'খ',
            3 => 'গ',
            4 => 'ঘ',
            5 => 'ঙ',
            6 => 'চ',
            7 => 'ছ',
            8 => 'জ',
            9 => 'ঝ',
            10 => 'ঞ',
            11 => 'ট',
            12 => 'ঠ',
            13 => 'ড',
            14 => 'ঢ',
            15 => 'ণ',
            16 => 'ত',
            17 => 'থ',
            18 => 'দ',
            19 => 'ধ',
            20 => 'ন',
            21 => 'প',
            22 => 'ফ',
            23 => 'ব',
            24 => 'ভ',
            25 => 'ম',
            26 => 'য',
            27 => 'র',
            28 => 'ল',
            29 => 'শ',
            30 => 'ষ',
            31 => 'স',
            32 => 'হ',
            33 => 'ড়',
            34 => 'ঢ়',
            35 => 'য়',
            36 => 'ৎ',
            37 => 'ং',
            38 => 'ঃ',
            39 => 'ঁ',
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
if (!function_exists('userCan')) {
    function userCan($permission)
    {
        if (auth()->check() && user()->can($permission)) {
            return true;
        }
        return false;
    }
}
/************************** Image **************************/

if (! function_exists('imgProcessAndStore')) {
    function imgProcessAndStore($image, string $path, ?array $size = null, $oldImage = null)
    {
        $dir = public_path('/uploads/images/' . $path);
        if (! is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $extension = strtolower($image->getClientOriginalExtension());

        if ($oldImage != null) {
            $checkPath = $dir . '/' . $oldImage;
            if ($oldImage && file_exists($checkPath)) {
                unlink($checkPath);
            }
        }

        if ($extension == 'svg') {
            $imageName = $path . '-' . uniqueId(10) . '.svg';
            $image->move($dir, $imageName);
        } else {
            $image = Image::make($image);
            if (! is_null($size) && count($size) == 2) {
                $image->fit($size[0], $size[1]);
            }

            if ($size[0] && $size[1] == null) {
                $image->resize($size[0], null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
            $uniqueId = uniqueId(10);

            if ($extension == 'png') {
                $imageName = $path . '-' . $uniqueId . '.png';
                $image->encode('png', 80)->save($dir . '/' . $imageName);
            } else {
                $imageName = $path . '-' . $uniqueId . '.webp';
                $image->encode('webp', 80)->save($dir . '/' . $imageName);
            }
        }

        return $imageName;
    }
}

if (!function_exists('imgWebpStore')) {
    function imgWebpStore($image, string $path, array $size = null)
    {
        $image = Image::make($image);
        if ($size[0] && $size[1]) {
            $image->fit($size[0], $size[1]);
        }

        if ($size[0] && $size[1] == null) {
            $image->resize($size[0], null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        $dir = public_path('/uploads/images/' . $path);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $imageName = $path . '-' . uniqueId(10) . '.webp';
        $image->encode('webp', 70)->save($dir . '/' . $imageName);
        return $imageName;
    }
}

if (!function_exists('imgWebpUpdate')) {
    function imgWebpUpdate($image, string $path, array $size = null, $oldImage)
    {
        $image = Image::make($image);
        if ($size[0] && $size[1]) {
            $image->fit($size[0], $size[1]);
        }

        if ($size[0] && $size[1] == null) {
            $image->resize($size[0], null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        $dir = public_path('/uploads/images/' . $path);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $imageName = $path . '-' . uniqueId(10) . '.webp';
        $image->encode('webp', 70)->save($dir . '/' . $imageName);

        $checkPath =  $dir . '/' . $oldImage;
        if ($oldImage && file_exists($checkPath)) {
            unlink($checkPath);
        }
        return $imageName;
    }
}
if (!function_exists('imgUnlink')) {
    function imgUnlink($folder, $image)
    {
        $path = public_path('uploads/images/' . $folder . '/' . $image);
        if ($image && file_exists($path)) {
            return unlink($path);
        }
    }
}


if (!function_exists('imageStore')) {
    function imageStore(Request $request, $request_name, string $name, string $path)
    {
        if ($request->hasFile($request_name)) {
            $pathCreate = public_path() . '/uploads/images/' . $path . '/';
            !file_exists($pathCreate) ?? File::makeDirectory($pathCreate, 0777, true, true);

            $image = $request->file($request_name);
            $imageName = $name . uniqueId(10) . '.' . $image->getClientOriginalExtension();
            if ($image->isValid()) {
                $request->$request_name->move(public_path() . '/uploads/images/' . $path . '/', $imageName);
                return $imageName;
            }
        }
    }
}

if (!function_exists('imageUpdate')) {
    function imageUpdate(Request $request, $request_name, string $name, string $path, $old_image)
    {
        if ($request->hasFile($request_name)) {
            $deletePath = public_path("uploads/images/{$path}/{$old_image}");

            if (!empty($old_image) && file_exists($deletePath)) {
                unlink($deletePath);
            }

            $createPath = public_path($path);
            if (!file_exists($createPath)) {
                File::makeDirectory($createPath, 0777, true, true);
            }

            $image = $request->file($request_name);
            $imageName = "{$name}_" . uniqueId(10) . '.' . $image->getClientOriginalExtension();

            if ($image->isValid()) {
                $image->move(public_path("uploads/images/{$path}/"), $imageName);
                return $imageName;
            }
        } else {
            return $old_image;
        }
    }
}

if (!function_exists('imagePath')) {
    function imagePath($folder, $image)
    {
        $path = 'uploads/images/' . $folder . '/' . $image;
        if (@GetImageSize($path)) {
            return asset($path);
        } else {
            return asset('uploads/images/no-img.jpg');
        }
    }
}

if (!function_exists('profileImg')) {
    function profileImg()
    {
        if (file_exists(asset('uploads/images/user/' . user()->image))) {
            return asset('uploads/images/user/' . user()->image);
        } else {
            return asset('uploads/images/icons/navy.jpg');
        }
    }
}
/************************** !Image **************************/
if (!function_exists('uniqueId')) {
    function uniqueId($lenght = 8)
    {
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            throw new \Exception("no cryptographically secure random function available");
        }
        return substr(bin2hex($bytes), 0, $lenght);
    }
}
