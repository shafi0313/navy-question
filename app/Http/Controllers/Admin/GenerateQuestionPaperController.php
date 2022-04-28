<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exam;
use App\Models\Chapter;
use App\Models\Subject;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

    public function create($examId)
    {
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }
        $exam = Exam::whereId($examId)->first();
        $chapters = Chapter::whereSubject_id($exam->subject_id)->get();
        return view('admin.generate_question_paper.create', compact('exam','chapters'));
    }

    public function getQuestion(Request $request)
    {
        if ($request->ajax()) {
            $questions = Question::whereChapter_id($request->chapterId)->get();
            // $questions = Question::whereExam_id($request->examId)->whereSubject_id($request->subjectId)->whereChapter_id($request->chapterId)->get();
            return response()->json(['questions'=>$questions,'status'=>200]);
        }
    }

    public function store(Request $request)
    {
        // foreach($request->question_id as $key => $value){
        //     $data=[
        //         'user_id' => auth()->user()->id,
        //         'exam_id' => $request->exam_id[$key],
        //         'question_id' => $request->question_id[$key],
            // ];

        // }
        try{
            Question::whereIn('id',$request->question_id)->update(['selected' => 1]);
            toast('success','Success');
            return redirect()->back();
        }catch(\Exception $ex){
            return $ex->getMessage();
            toast('error','Error');
            return redirect()->back();
        }
    }

    public function show($examId)
    {
        $questions = Question::with('options')->whereExam_id($examId)->get();
        return view('admin.generate_question_paper.show', compact('questions'));
    }
}
