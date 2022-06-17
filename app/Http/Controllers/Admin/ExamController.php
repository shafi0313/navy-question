<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exam;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ExamController extends Controller
{
    public function index()
    {
        if ($error = $this->sendPermissionError('index')) {
            return $error;
        }
        $exams = Exam::all();
        return view('admin.exam.index', compact('exams'));
    }

    public function create()
    {
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }
        $subjects = Subject::all();
        return view('admin.exam.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }
        $data = $this->validate($request, [
            'name' => 'required|max:100',
        ]);
        $data['user_id'] = auth()->user()->id;
        DB::beginTransaction();
        try{
            Exam::create($data);
            DB::commit();
            toast('Success!','success');
            return redirect()->route('admin.exam.index');
        }catch(\Exception $ex){
            DB::rollBack();
            toast('error','Error');
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if ($error = $this->sendPermissionError('edit')) {
            return $error;
        }
        $exam = Exam::find($id);
        return view('admin.exam.edit', compact('exam'));
    }

    public function update(Request $request, $id)
    {
        if ($error = $this->sendPermissionError('edit')) {
            return $error;
        }

        $data = $this->validate($request, [
            'name' => 'required|max:100',
        ]);

        $data['user_id'] = auth()->user()->id;
        DB::beginTransaction();
        try{
            Exam::find($id)->update($data);
            DB::commit();
            toast('Success!','success');
            return redirect()->route('admin.exam.index');
        }catch(\Exception $ex){
            DB::rollBack();
            toast('Error','error');
            return redirect()->back();
        }
    }


    public function destroy($id)
    {
        if ($error = $this->sendPermissionError('delete')) {
            return $error;
        }
        try{
            Exam::find($id)->delete();
            toast('Success!','success');
            return redirect()->back();
        }catch(\Exception $ex){
            DB::rollBack();
            toast('Error','error');
            return redirect()->back();
        }
    }
}
