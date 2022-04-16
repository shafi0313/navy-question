<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exam;
use App\Models\Chapter;
use App\Models\Subject;
use App\Models\Question;
use App\Models\QuesOption;
use App\Models\QuesGenerate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class QuestionEntryController extends Controller
{
    public function index()
    {
        if ($error = $this->sendPermissionError('index')) {
            return $error;
        }
        $questions = Question::all();
        return view('admin.question_entry.index', compact('questions'));
    }

    public function create($examId)
    {
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }
        $exam = Exam::whereId($examId)->first();
        $chapters = Chapter::whereSubject_id($exam->subject_id)->get();
        return view('admin.question_entry.create', compact('exam','chapters'));
    }

    public function store(Request $request)
    {
        // return $request;
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }

        $data = $this->validate($request, [
            'exam_id' => 'required|integer',
            'subject_id' => 'required|integer',
            'chapter_id' => 'required|integer',
            'type' => 'required',
            'mark' => 'required',
            'ques' => 'required',
        ]);
        $data['user_id'] = auth()->user()->id;

        DB::beginTransaction();
        $question = Question::create($data);

        if($request->type == "Multiple Choice"){
            foreach($request->option as $key => $value){
                $option=[
                    'question_id' => $question->id,
                    'option' => $request->option[$key],
                ];
                QuesOption::create($option);
            }
        }

        try{
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

 

    public function edit($id)
    {
        if ($error = $this->sendPermissionError('edit')) {
            return $error;
        }
        $question = Question::with('options')->find($id);
        $exams = Exam::all();
        return view('admin.question_entry.edit', compact('question','exams'));
    }

    public function update(Request $request, $id)
    {
        if ($error = $this->sendPermissionError('edit')) {
            return $error;
        }
        $data = $this->validate($request, [
            'exam_id' => 'required|integer',
            'subject_id' => 'required|integer',
            'chapter_id' => 'required|integer',
            'type' => 'required',
            'mark' => 'required',
            'ques' => 'required',
        ]);
        $data['user_id'] = auth()->user()->id;

        DB::beginTransaction();
        Question::find($id)->update($data);

        if($request->type == "Multiple Choice"){
            foreach($request->option as $key => $value){
                $option=[
                    'question_id' => $id,
                    'option' => $request->option[$key],
                ];
                QuesOption::updateOrCreate(['id' => $request->option_id],$option);
            }
        }

        try{
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
        $user = Question::find($id);
        $path =  public_path('uploads/images/users/'.$user->image);
        if(file_exists($path) && !is_null($user->image)){
            unlink($path);
            $user->delete();
            toast('Successfully Deleted','success');
            return redirect()->back();
        }else{
            $user->delete();
            toast('Successfully Deleted','success');
            return redirect()->back();
        }
    }
    public function optionDestroy($id)
    {
        if ($error = $this->sendPermissionError('delete')) {
            return $error;
        }
        try{
            QuesOption::find($id)->delete();
            toast('Success!','success');
            return back();
        }catch(\Exception $e){
            toast('Failed!','error');
            return back();
        }
    }

    public function getSubject(Request $request)
    {
        if ($request->ajax()) {
            $subjectId = Exam::find($request->examId)->subject_id;
            $subjects = Subject::whereId($subjectId)->get();
            return response()->json(['subjects'=>$subjects,'status'=>200]);
        }
    }
    public function getChapter(Request $request)
    {
        if ($request->ajax()) {
            $chapters = Chapter::whereSubject_id($request->subjectId)->get();
            return response()->json(['chapters'=>$chapters,'status'=>200]);
        }
    }
}

