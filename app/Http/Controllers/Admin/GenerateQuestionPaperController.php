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
        if ($error = $this->authorize('question-generate-manage')) {
            return $error;
        }
        // $datum = QuesInfo::with(['exam'])->select('*', DB::raw('DATE_FORMAT(date, "%Y") as date'))->whereStatus('Pending')->get()->groupBy('date');
        $datum = QuesInfo::with(['exam'])->whereStatus('Pending')->get()->groupBy('exam_id');
        return view('admin.generate_question_paper.index', compact('datum'));
    }

    public function showBySubject($year)
    {
        // $datum = QuesInfo::with(['exam'])->whereSet($set)->get();
        $datum = QuesInfo::with(['exam'])->whereYear('date', $year)->whereStatus('Pending')->get();
        // $datum = QuesInfo::with(['exam'])->whereSubject_id($subjectId)->whereStatus('Pending')->whereYear('date',$year)->get();
        return view('admin.generate_question_paper.subject_show', compact('datum'));
    }

    public function show($quesInfoId)
    {
        $questionPapers = QuestionPaper::with(['question'])->whereQues_info_id($quesInfoId)->get();
        $quesInfo = QuesInfo::find($quesInfoId);
        if ($questionPapers->count() < 1) {
            Alert::info('No Data Found');
            return back();
        }
        $exams = Exam::all();
        $chapters = Chapter::whereSubject_id($questionPapers->first()->question->subject_id)->get();
        return view('admin.generate_question_paper.show', compact('exams','questionPapers', 'chapters', 'quesInfoId', 'quesInfo'));
    }

    // public function showBySet($subjectId,$year)
    // {
    //     // $datum = QuesInfo::with(['exam'])->whereSet($set)->get();
    //     $datum = QuesInfo::with(['exam'])->whereSubject_id($subjectId)->whereStatus('Pending')->whereYear('date',$year)->get();
    //     return view('admin.generate_question_paper.set_show', compact('datum'));
    // }

    public function create()
    {
        if ($error = $this->authorize('question-generate-add')) {
            return $error;
        }

        // $subjects = Subject::all();
        // $chapters = Chapter::all();
        $exams = Exam::all();
        return view('admin.generate_question_paper.create', compact('exams'));
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
        // return
        if ($error = $this->authorize('question-generate-add')) {
            return $error;
        }
        DB::beginTransaction();
        $quesInfo = $request->validate([
            'exam_id' => 'required|numeric',
            'subject_id' => 'required',
            'date' => 'required',
            'time' => 'nullable',
            'd_hour' => 'sometimes',
            'd_minute' => 'sometimes',
            'mode' => 'required',
            'trade' => 'nullable',
        ]);
        $quesInfo['status'] = 'Pending';
        $quesInfo['user_id'] = auth()->user()->id;
        $quesInfo['set'] = QuesInfo::whereYear('date', now('Y'))->whereExam_id($request->exam_id)->whereSubject_id($request->subject_id)->count() + 1;
        $questionInfo = QuesInfo::create($quesInfo);

        // return $request->subject_id;

        $quesMarks = MarkDistribution::whereSubject_id($request->subject_id)->get();
        if ($quesMarks->count() < 1) {
            Alert::info('At first, distribute the subject marks then generate the question');
            return back();
        }

        // $multipleQues = $quesMarks->whereType('Multiple Choice');
        // $questions = Question::whereSubject_id($request->subject_id)->whereIn($multipleQues->pluck('chapter_id'))->whereType('Multiple Choice')->inRandomOrder()->limit($multipleQuesMark)->get()->pluck('id');
        foreach ($quesMarks as $k => $v) {
            $questions = Question::whereExam_id($request->exam_id)
                                ->whereSubject_id($request->subject_id)
                                // ->whereChapter_id($v->pluck('chapter_id')[$k])
                                ->whereIn('chapter_id', [$v->chapter_id])
                                ->whereType('Multiple Choice')->inRandomOrder()
                                ->limit($v->multiple)
                                ->get()
                                ->pluck('id');

            foreach ($questions as $key => $value) {
                $data=[
                    'ques_info_id' => $questionInfo->id,
                    'question_id' => $value,
                    'type' => 'Multiple Choice',
                ];
                QuestionPaper::updateOrCreate($data);
            }
        }

        foreach ($quesMarks as $k => $v) {
             $questions = Question::whereExam_id($request->exam_id)
                                ->whereSubject_id($request->subject_id)
                                ->whereIn('chapter_id', [$v->chapter_id])
                                ->whereType('Short Question')->inRandomOrder()
                                ->limit($v->sort/2)
                                ->get()
                                ->pluck('id');

            foreach ($questions as $key => $value) {
                $data=[
                    'ques_info_id' => $questionInfo->id,
                    'question_id' => $value,
                    'type' => 'Short Question',
                ];
                QuestionPaper::updateOrCreate($data);
            }
        }

        foreach ($quesMarks as $k => $v) {
            $questions = Question::whereExam_id($request->exam_id)
                                ->whereSubject_id($request->subject_id)
                                // ->whereChapter_id($v->pluck('chapter_id')[$k])
                                ->whereIn('chapter_id', [$v->chapter_id])
                                ->whereType('Long Question')->inRandomOrder()
                                ->limit($v->long/5)
                                ->get()
                                ->pluck('id');

            foreach ($questions as $key => $value) {
                $data=[
                    'ques_info_id' => $questionInfo->id,
                    'question_id' => $value,
                    'type' => 'Long Question',
                ];
                QuestionPaper::updateOrCreate($data);
            }
        }

        try {
            toast('Success!', 'success');
            DB::commit();
            return redirect()->route('admin.generateQuestion.show', $questionInfo->id);
        } catch (\Exception $ex) {
            return $ex->getMessage();
            toast('Error', 'error');
            DB::rollBack();
            return back();
        }
    }

    public function addQues(Request $request)
    {
        foreach ($request->question_id as $k => $v) {
            $data = [
                'ques_info_id' => $request->ques_info_id,
                'question_id' => $request->question_id[$k],
                'type' => $request->type,
            ];
            QuestionPaper::updateOrCreate($data);
        }
        try {
            toast('Success!', 'success');
            DB::commit();
            return back();
        } catch (\Exception $ex) {
            return $ex->getMessage();
            toast('Error', 'error');
            DB::rollBack();
            return redirect()->back();
        }
    }



    public function complete(Request $request)
    {
        if ($error = $this->authorize('question-generate-generate')) {
            return $error;
        }
        $quesInfo = QuesInfo::find($request->quesInfoId);
        try {
            $quesInfo->update(['status'=>'Completed']);
            toast('Success!', 'success');
            return redirect()->route('admin.generateQuestion.showBySubject', Carbon::parse($quesInfo->date)->format('Y'));
        } catch (\Exception $ex) {
            toast('Error', 'error');
            return redirect()->back();
        }
    }


    public function edit($id, $quesInfoId)
    {
        if ($error = $this->authorize('question-generate-edit')) {
            return $error;
        }
        $question = Question::with('options')->find($id);
        $exams = Exam::all();
        return view('admin.generate_question_paper.edit', compact('question', 'exams', 'quesInfoId'));
    }

    public function update(Request $request, $quesId)
    {
        if ($error = $this->authorize('ques-generate-edit')) {
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

        if ($request->type == "Multiple Choice") {
            foreach ($request->option as $key => $value) {
                $option=[
                    'question_id' => $quesId,
                    'option' => $request->option[$key],
                ];
                if (!empty(QuesOption::whereId($request->option_id[$key]))) {
                    QuesOption::where('id', $request->option_id[$key])->update($option);
                } else {
                    QuesOption::create($option);
                }
                // QuesOption::updateOrCreate(['id' => $request->option_id],$option);
                // $update = QuesOption::where('id', $request->option_id[$key])->update($option);
                // if(!$update){
                //     QuesOption::create($option);
                // }
            }
        }

        try {
            DB::commit();
            toast('Success!', 'success');
            return redirect()->route('admin.generateQuestion.show', $request->quesInfoId);
        } catch (\Exception $ex) {
            return $ex->getMessage();
            DB::rollBack();
            toast('error', 'Error');
            return redirect()->back();
        }
    }


    public function quesDestroy($id)
    {
        if ($error = $this->authorize('question-generate-delete')) {
            return $error;
        }
        try {
            QuestionPaper::whereQuestion_id($id)->first()->delete();
            toast('Success!', 'success');
            return back();
        } catch (\Exception $ex) {
            toast('Error', 'error');
            return redirect()->back();
        }
    }
}
