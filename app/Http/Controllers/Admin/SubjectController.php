<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SubjectController extends Controller
{
    public function index()
    {
        if ($error = $this->authorize('subject-manage')) {
            return $error;
        }
        $subjects = Subject::with('chapters')->get();
        return view('admin.subject.index', compact('subjects'));
    }

    public function store(Request $request)
    {
        if ($error = $this->authorize('subject-add')) {
            return $error;
        }
        $data = $this->validate($request, [
            'name' => 'required|max:191',
        ]);

        DB::beginTransaction();

        try{
            Subject::create($data);
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
        if ($error = $this->authorize('subject-edit')) {
            return $error;
        }
        $data = $this->validate($request, [
            'name' => 'required|max:191',
        ]);

        DB::beginTransaction();

        try{
            Subject::find($id)->update($data);
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
        if ($error = $this->authorize('subject-delete')) {
            return $error;
        }
        try{
            Subject::find($id)->delete();
            toast('Success!','success');
            return redirect()->back();
        }catch(\Exception $ex){
            toast('Failed','error');
            return redirect()->back();
        }
    }
}
