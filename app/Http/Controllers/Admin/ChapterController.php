<?php

namespace App\Http\Controllers\Admin;

use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ChapterController extends Controller
{
    // public function index()
    // {
    //     if ($error = $this->sendPermissionError('index')) {
    //         return $error;
    //     }
    //     $subjects = Chapter::all();
    //     return view('admin.subject.index', compact('subjects'));
    // }

    public function store(Request $request)
    {
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }
        $data = $this->validate($request, [
            'subject_id' => 'required|numeric',
            'name' => 'required|max:191',
        ]);

        DB::beginTransaction();

        try{
            Chapter::create($data);
            DB::commit();
            toast('success','Success');
            return redirect()->back();
        }catch(\Exception $ex){
            return $ex->getMessage();
            DB::rollBack();
            toast('error','Error');
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        if ($error = $this->sendPermissionError('edit')) {
            return $error;
        }
        $data = $this->validate($request, [
            'name' => 'required|max:191',
        ]);

        DB::beginTransaction();

        try{
            Chapter::find($id)->update($data);
            DB::commit();
            toast('success','Success');
            return redirect()->back();
        }catch(\Exception $ex){
            return $ex->getMessage();
            DB::rollBack();
            toast('error','Error');
            return redirect()->back();
        }
    }


    public function destroy($id)
    {
        if ($error = $this->sendPermissionError('delete')) {
            return $error;
        }
        try{
            Chapter::find($id)->delete();
            toast('Success!','success');
            return redirect()->back();
        }catch(\Exception $ex){
            toast('Failed','error');
            return redirect()->back();
        }
    }
}
