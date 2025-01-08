<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChapterController extends Controller
{
    // public function index()
    // {
    //     if ($error = $this->sendPermissionError('index')) {
    //         return $error;
    //     }
    //     $subjects = Chapter::all();
    //     return view('admin.subjects.index', compact('subjects'));
    // }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'subject_id' => 'required|numeric',
            'name' => 'required|max:191',
        ]);

        DB::beginTransaction();

        try {
            Chapter::create($data);
            DB::commit();
            toast('Success!', 'success');

            return redirect()->back();
        } catch (\Exception $ex) {
            // // return $ex->getMessage();
            DB::rollBack();
            toast('Error', 'error');

            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $data = $this->validate($request, [
            'name' => 'required|max:191',
        ]);

        DB::beginTransaction();

        try {
            Chapter::find($id)->update($data);
            DB::commit();
            toast('Success', 'success');

            return redirect()->back();
        } catch (\Exception $ex) {
            // return $ex->getMessage();
            DB::rollBack();
            toast('Error', 'error');

            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            Chapter::find($id)->delete();
            toast('Success!', 'success');

            return redirect()->back();
        } catch (\Exception $ex) {
            toast('Failed', 'error');

            return redirect()->back();
        }
    }
}
