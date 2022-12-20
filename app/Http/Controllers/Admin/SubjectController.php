<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exam;
use App\Models\Chapter;
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
        $exams = Exam::all();
        $subjects = Subject::with('chapters')->get();
        return view('admin.subject.index', compact('subjects','exams'));
    }

    public function store(Request $request)
    {
        if ($error = $this->authorize('subject-add')) {
            return $error;
        }
        $data = $this->validate($request, [
            'exam_id' => 'required|numeric',
            'name' => 'required|max:191',
        ]);

        DB::beginTransaction();

        try{
            Subject::create($data);
            DB::commit();
            toast('Success!','success');
            return redirect()->back();
        }catch(\Exception $ex){
            // // return $ex->getMessage();
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
            'exam_id' => 'required|numeric',
            'name' => 'required|max:191',
        ]);

        DB::beginTransaction();

        try{
            Subject::find($id)->update($data);
            DB::commit();
            toast('success','Success');
            return redirect()->back();
        }catch(\Exception $ex){
            // return $ex->getMessage();
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
            Chapter::whereSubject_id($id)->delete();
            toast('Success!','success');
            return redirect()->back();
        }catch(\Exception $ex){
            toast('Failed','error');
            return redirect()->back();
        }
    }
}
