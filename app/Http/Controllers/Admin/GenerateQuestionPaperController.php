<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exam;
use App\Models\Chapter;
use App\Models\Subject;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\QuestionPaper;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class GenerateQuestionPaperController extends Controller
{
    public function index()
    {
        if ($error = $this->sendPermissionError('index')) {
            return $error;
        }
        $subjects = Subject::all();
        $chapters = Chapter::all();
        $exams = Exam::all();
        return view('admin.generate_question_paper.index', compact('subjects','chapters','exams'));
    }

    public function getQuestion(Request $request)
    {
        if ($request->ajax()) {
            $questions = Question::whereChapter_id($request->chapterId)->whereType($request->quesType)->get();
            return response()->json(['questions'=>$questions,'status'=>200]);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'exam_id' => 'required',
            'subject_id' => 'required',
            'chapter_id' => 'required',
            'type' => 'required',
        ]);
        if($request->has('question_id') && !empty($request->question_id)){
            $type = Question::whereIn('id',$request->question_id)->get(['type'])->pluck('type');
            foreach($request->question_id as $key => $value){
                $data=[
                    'user_id' => auth()->user()->id,
                    'exam_id' => $request->exam_id,
                    'subject_id' => $request->subject_id,
                    'question_id' => $request->question_id[$key],
                    'type' => $type[$key],
                ];
                QuestionPaper::updateOrCreate($data);
            }
        }else{
            if($request->type != 'Multiple Choice'){
                Alert::info('Percentage worked only for multiple choice');
                return back();
            }
            $percentage = Exam::find($request->exam_id)->total_mark * $request->percentage / 100;
            $questions = Question::whereSubject_id($request->subject_id)->whereChapter_id($request->chapter_id)->whereType('Multiple Choice')->inRandomOrder()->limit(round($percentage))->get()->pluck('id');
            foreach($questions as $key => $value){
                $data=[
                    'user_id' => auth()->user()->id,
                    'exam_id' => $request->exam_id,
                    'subject_id' => $request->subject_id,
                    'question_id' => $value,
                    'type' => $request->type,
                ];
                QuestionPaper::updateOrCreate($data);
            }
        }

        try{
            toast('Success!','success');
            return redirect()->back();
        }catch(\Exception $ex){
            return $ex->getMessage();
            toast('Error','error');
            return redirect()->back();
        }
    }

    public function show($examId)
    {
        $questions = Question::with('options')->whereExam_id($examId)->get();
        return view('admin.generate_question_paper.show', compact('questions'));
    }
}
