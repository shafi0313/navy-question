<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Exam;
use App\Models\Chapter;
use App\Models\Subject;
use App\Models\QuesInfo;
use App\Models\Question;
use App\Models\QuesOption;
use Illuminate\Http\Request;
use App\Models\QuestionPaper;
use App\Models\MarkDistribution;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class GenerateQuestionPaperController extends Controller
{
    public function index()
    {
        if ($error = $this->sendPermissionError('index')) {
            return $error;
        }
        $datum = QuesInfo::with(['exam'])->select('*',DB::raw('DATE_FORMAT(date_time, "%Y") as date'))->whereStatus('Pending')->get()->groupBy('date');
        return view('admin.generate_question_paper.index', compact('datum'));
    }

    public function showBySubject($year)
    {
        // $datum = QuesInfo::with(['exam'])->whereSet($set)->get();
        $datum = QuesInfo::with(['exam'])->whereYear('date_time',$year)->whereStatus('Pending')->get()->groupBy('subject_id');
        return view('admin.generate_question_paper.subject_show', compact('datum'));
    }

    public function showBySet($subjectId,$year)
    {
        // $datum = QuesInfo::with(['exam'])->whereSet($set)->get();
        $datum = QuesInfo::with(['exam'])->whereSubject_id($subjectId)->whereStatus('Pending')->whereYear('date_time',$year)->get();
        return view('admin.generate_question_paper.set_show', compact('datum'));
    }

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
        DB::beginTransaction();
        $quesInfo = $request->validate([
            'exam_id' => 'required',
            'subject_id' => 'required',
            'date_time' => 'required|after:starting_hour',
            'd_hour' => 'sometimes',
            'd_minute' => 'sometimes',
            'mode' => 'required',
            'trade' => 'nullable',
        ]);
        $quesInfo['status'] = 'Pending';
        $quesInfo['user_id'] = auth()->user()->id;
        $quesInfo['set'] = QuesInfo::whereExam_id($request->exam_id)->whereSubject_id($request->subject_id)->whereStatus('Pending')->count() + 1;
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

        foreach($quesMarks as $k => $v){
            $questions = Question::whereSubject_id($request->subject_id)
                                ->whereChapter_id($v->pluck('chapter_id')[$k])
                                ->whereType('Short Question')->inRandomOrder()
                                ->limit($v->sort/2)
                                ->get()
                                ->pluck('id');

            foreach($questions as $key => $value){
                $data=[
                    'ques_info_id' => $questionInfo->id,
                    'question_id' => $value,
                    'type' => 'Short Question',
                ];
                QuestionPaper::updateOrCreate($data);
            }
        }

        foreach($quesMarks as $k => $v){
            $questions = Question::whereSubject_id($request->subject_id)
                                ->whereChapter_id($v->pluck('chapter_id')[$k])
                                ->whereType('Long Question')->inRandomOrder()
                                ->limit($v->long/5)
                                ->get()
                                ->pluck('id');

            foreach($questions as $key => $value){
                $data=[
                    'ques_info_id' => $questionInfo->id,
                    'question_id' => $value,
                    'type' => 'Long Question',
                ];
                QuestionPaper::updateOrCreate($data);
            }
        }

        try{
            toast('Success!','success');
            DB::commit();
            return redirect()->route('admin.generateQuestion.show',$questionInfo->id);
        }catch(\Exception $ex){
            return $ex->getMessage();
            toast('Error','error');
            DB::rollBack();
            return redirect()->back();
        }
    }

    public function addQues(Request $request)
    {
        foreach($request->question_id as $k => $v){
            $data = [
                'ques_info_id' => $request->ques_info_id,
                'question_id' => $request->question_id[$k],
                'type' => $request->type,
            ];
            QuestionPaper::updateOrCreate($data);
        }
        try{
            toast('Success!','success');
            DB::commit();
            return back();
        }catch(\Exception $ex){
            return $ex->getMessage();
            toast('Error','error');
            DB::rollBack();
            return redirect()->back();
        }
    }

    public function show($quesInfoId)
    {

        $questionPapers = QuestionPaper::with(['question'])->whereQues_info_id($quesInfoId)->get();
        $chapters = Chapter::whereSubject_id($questionPapers->first()->question->subject_id)->get();
        return view('admin.generate_question_paper.show', compact('questionPapers','chapters','quesInfoId'));
    }

    public function complete(Request $request)
    {
        $quesInfo = QuesInfo::find($request->quesInfoId);
        try{
            $quesInfo->update(['status'=>'Completed']);
            toast('Success!','success');
            return redirect()->route('admin.generateQuestion.showBySubject', Carbon::parse($quesInfo->date_time)->format('Y'));
        }catch(\Exception $ex){
            toast('Error','error');
            return redirect()->back();
        }
    }


    public function edit($id, $quesInfoId)
    {
        if ($error = $this->sendPermissionError('edit')) {
            return $error;
        }
        $question = Question::with('options')->find($id);
        $exams = Exam::all();
        return view('admin.generate_question_paper.edit', compact('question','exams','quesInfoId'));
    }

    public function update(Request $request, $quesId)
    {
        if ($error = $this->sendPermissionError('edit')) {
            return $error;
        }
        $data = $this->validate($request, [
            'subject_id' => 'required|integer',
            'chapter_id' => 'required|integer',
            'type' => 'required',
            'mark' => 'required',
            'ques' => 'required',
        ]);
        $data['user_id'] = auth()->user()->id;

        DB::beginTransaction();
        Question::find($quesId)->update($data);

        if($request->type == "Multiple Choice"){
            foreach($request->option as $key => $value){
                $option=[
                    'question_id' => $quesId,
                    'option' => $request->option[$key],
                ];
                if(!empty(QuesOption::whereId($request->option_id[$key]))){
                    QuesOption::where('id', $request->option_id[$key])->update($option);
                }else{
                    QuesOption::create($option);
                }
                // QuesOption::updateOrCreate(['id' => $request->option_id],$option);
                // $update = QuesOption::where('id', $request->option_id[$key])->update($option);
                // if(!$update){
                //     QuesOption::create($option);
                // }
            }
        }

        try{
            DB::commit();
            toast('Success!','success');
            return redirect()->route('admin.generateQuestion.show',$request->quesInfoId);
        }catch(\Exception $ex){
            return $ex->getMessage();
            DB::rollBack();
            toast('error','Error');
            return redirect()->back();
        }
    }


    public function quesDestroy($id)
    {
        try{
            QuestionPaper::whereQuestion_id($id)->first()->delete();
            toast('Success!','success');
            return back();
        }catch(\Exception $ex){
            toast('Error','error');
            return redirect()->back();
        }
    }
}
