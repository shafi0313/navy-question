<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisitorInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class VisitorInfoController extends Controller
{
    public function index()
    {
        $visitors = VisitorInfo::all();

        return view('admin.visitor_info.index', compact('visitors'));
    }

    public function destroySelected(Request $request)
    {
        try {
            VisitorInfo::whereIn('id', $request->id)->delete();
            Alert::success('Visitor Information Deleted');
        } catch (\Exception $e) {
            Alert::error('Oops server error');
        }

        return back();
    }

    public function destroyAll()
    {
        try {
            DB::table('visitor_infos')->delete();
            Alert::success('All Visitor Information Deleted');
        } catch (\Exception $e) {
            Alert::error('Oops server error');
        }

        return back();
    }
}
