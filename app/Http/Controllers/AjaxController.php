<?php

namespace App\Http\Controllers;

use App\Models\SessionYear;
use Illuminate\Http\Request;

class AjaxController extends Controller
{

    public function deleteAll(Request $request, $model)
    {
        if ($request->ajax()) {
            try {
                $dir = "App\Models\\";
                app($dir . $model)->whereIn('id', $request->ids)->each(function ($arg) use ($model) {
                    if ($arg->image) {
                        $path = public_path($arg->image);
                        if (file_exists($path) && !is_dir($path)) {
                            unlink($path);
                        }
                    }
                    $arg->delete();
                    // activity()
                    //     ->performedOn($arg)
                    //     ->withProperties(['name' => $arg->name, 'by' => user()->username])
                    //     ->causedBy(user())
                    //     ->log($model . ' Was Soft Deleted');
                });
                return response()->json(['message' => 'Soft Deleted Successfully'], 200);
            } catch (\Exception $e) {
                return response()->json(['message' => __('app.oops')], 200);
                // return $e->getMessage();
            }
        }
        return abort(500);
    }
    public function forceDeleteAll(Request $request, $model)
    {
        if ($request->ajax()) {
            try {
                $dir = "App\Models\\";
                app($dir . $model)->whereIn('id', $request->ids)->each(function ($arg) use ($model) {
                    if ($arg->image) {
                        $path = public_path($arg->image);
                        if (file_exists($path) && !is_dir($path)) {
                            unlink($path);
                        }
                    }
                    $arg->delete();
                    // activity()
                    //     ->performedOn($arg)
                    //     ->withProperties(['name' => $arg->name, 'by' => user()->username])
                    //     ->causedBy(user())
                    //     ->log($model . ' Was Deleted');
                });
                return response()->json(['message' => 'Deleted Successfully'], 200);
            } catch (\Exception $e) {
                return response()->json(['message' => __('app.oops')], 200);
                // return $e->getMessage();
            }
        }
        return abort(500);
    }
    public function select2(Request $request, $model)
    {
        if ($request->ajax()) {
            try {
                $formatted_array = [];
                if ($model == 'session') {
                    $sessions = SessionYear::where('year', 'like', "%{$request->q}%")->select('id', 'year')->limit(15)->get();
                    foreach ($sessions as $arr) {
                        $formatted_array[] = ['id' => $arr->id, 'text' => $arr->year];
                    }
                }
                return response()->json($formatted_array, 200);
            } catch (\Exception $e) {
                return response()->json(['id' => 0, 'text' => 'No record found!'], 500);
                // return $e->getMessage();
            }
        }
        return abort(500);
    }
}
