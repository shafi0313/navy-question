<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exam;
use App\Models\Chapter;
use App\Models\Subject;
use App\Models\QuesInfo;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\QuestionPaper;
use App\Models\MarkDistribution;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class GenerateQuestionPaperController extends Controller
{
    public function create()
    {
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }
        $subjects = Subject::all();
        $chapters = Chapter::all();
        $exams = Exam::all();
        return view('admin.generate_question_paper.create', compact('subjects','chapters','exams'));
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
        // $this->validate($request, [
        //     'exam_id' => 'required',
        //     'subject_id' => 'required',
        //     // 'chapter_id' => 'required',
        //     // 'type' => 'required',
        // ]);
        DB::beginTransaction();
        $quesInfo = $request->validate([
            'exam_id' => 'required',
            'subject_id' => 'required',
            'code' => 'required|max:60',
            'date_time' => 'required|after:starting_hour',
            'd_hour' => 'sometimes',
            'd_minute' => 'sometimes',
            'mode' => 'required',
            'trade' => 'nullable',
            'total_mark' => 'required|integer',
            'pass_mark' => 'required|integer',
        ]);
        $quesInfo['user_id'] = auth()->user()->id;
        $quesInfo['set'] = QuesInfo::whereExam_id($request->exam_id)->whereSubject_id($request->subject_id)->count() + 1;
        $questionInfo = QuesInfo::create($quesInfo);


        $quesMarks = MarkDistribution::whereSubject_id($request->subject_id)->get();
        // $multipleQues = $quesMarks->whereType('Multiple Choice');
        // $questions = Question::whereSubject_id($request->subject_id)->whereIn($multipleQues->pluck('chapter_id'))->whereType('Multiple Choice')->inRandomOrder()->limit($multipleQuesMark)->get()->pluck('id');
        foreach($quesMarks as $k => $v){
            $questions = Question::whereSubject_id($request->subject_id)
                                ->whereChapter_id($v->pluck('chapter_id')[$k])
                                ->whereType('Multiple Choice')->inRandomOrder()
                                ->limit($v->multiple)
                                ->get()
                                ->pluck('id');

            foreach($questions as $key => $value){
                $data=[
                    'ques_info_id' => $questionInfo->id,
                    'question_id' => $value,
                    'type' => 'Multiple Choice',
                ];
                QuestionPaper::updateOrCreate($data);
            }
        }

        try{
            toast('Success!','success');
            DB::commit();
            return redirect()->back();
        }catch(\Exception $ex){
            return $ex->getMessage();
            toast('Error','error');
            DB::rollBack();
            return redirect()->back();
        }
    }

    public function show($examId)
    {
        $questions = Question::with('options')->whereExam_id($examId)->get();
        return view('admin.generate_question_paper.show', compact('questions'));
    }
}
