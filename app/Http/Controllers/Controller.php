<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use RealRashid\SweetAlert\Facades\Alert;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function authorize(
        $permission,
        $error_message = 'Don\'t have permission to perform this action',
    ) {
        if (! user()->can($permission)) {
            Alert::info($error_message);
            // return redirect()->back()->withInput()->withErrors($error_message);
        }
    }
}
