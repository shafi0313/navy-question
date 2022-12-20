<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Exam;
use App\Models\Chapter;
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

    public function showBySubject($examId)
    {
        // $datum = QuesInfo::with(['exam'])->whereSet($set)->get();
        $datum = QuesInfo::with(['exam'])->whereExam_id($examId)->whereStatus('Pending')->get();
        // $datum = QuesInfo::with(['exam'])->whereSubject_id($subjectId)->whereStatus('Pending')->whereYear('date',$year)->get();
        return view('admin.generate_question_paper.subject_show', compact('datum'));
    }

    public function show($quesInfoId)
    {
        // $questionPapers = QuestionPaper::with(['question'])->whereQues_info_id($quesInfoId)->get();
        $chapters = QuestionPaper::with(['quesInfo','options'])
                            ->join('questions','questions.id', '=', 'question_papers.question_id')
                            ->whereQues_info_id($quesInfoId)
                            ->get()
                            ->groupBy('chapter_id');
        $quesInfo = QuesInfo::find($quesInfoId);
        if ($chapters->count() < 1) {
            Alert::info('No Data Found');
            return back();
        }
        $exams = Exam::all();
        $mainChapters = Chapter::whereSubject_id($chapters->first()->first()->question->subject_id)->get();
        return view('admin.generate_question_paper.show', compact('exams', 'mainChapters', 'chapters', 'quesInfoId', 'quesInfo'));
    }

    public function create()
    {
        if ($error = $this->authorize('question-generate-add')) {
            return $error;
        }
        $exams = Exam::all();
        return view('admin.generate_question_paper.create', compact('exams'));
    }

    public function getQuestion(Request $request)
    {
        if ($request->ajax()) {
            // $questions = Question::whereChapter_id($request->chapterId)->whereType($request->quesType)->get();
            $questions = Question::whereNotIn('id',$request->quesId)->whereChapter_id($request->chapterId)->whereType($request->quesType)->get();
            return response()->json(['questions'=>$questions,'status'=>200]);
        }
    }

    public function store(Request $request)
    {
        if ($error = $this->authorize('question-generate-add')) {
            return $error;
        }
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
        DB::beginTransaction();
        $quesMarks = MarkDistribution::whereSubject_id($request->subject_id)->get();
        // Mark Distribution Check
        if ($quesMarks->count() < 1) {
            Alert::info('At first, distribute the subject marks then generate the question');
            return back();
        }
        // Question Count Check
        if(Question::whereExam_id($request->exam_id)->whereSubject_id($request->subject_id)->whereIn('chapter_id', $quesMarks->pluck('chapter_id'))->get()->count() < 1) {
            Alert::info('No Data Found');
            return back();
        }
        $questionInfo = QuesInfo::create($quesInfo);
        foreach ($quesMarks as $k => $v) {
            $questions = Question::whereExam_id($request->exam_id)
                                ->whereSubject_id($request->subject_id)
                                ->where('chapter_id', $v->chapter_id)
                                ->whereType('multiple_choice')
                                ->inRandomOrder()
                                ->get();
            $i=0;
            foreach ($questions as $key => $value) {
                if ($i < $v->multiple) {
                    $data=[
                        'ques_info_id' => $questionInfo->id,
                        'question_id' => $value->id,
                        'type' => 'multiple_choice',
                    ];
                    QuestionPaper::updateOrCreate($data);
                    $i += $value->mark;
                }
            }
        }

        foreach ($quesMarks as $k => $v) {
            $questions = Question::whereExam_id($request->exam_id)
                                ->whereSubject_id($request->subject_id)
                                ->where('chapter_id', $v->chapter_id)
                                ->whereType('short_question')
                                ->inRandomOrder()
                                ->get();
            $j=0;
            foreach ($questions as $key => $value) {
                if ($j < $v->sort) {
                    $data=[
                        'ques_info_id' => $questionInfo->id,
                        'question_id' => $value->id,
                        'type' => 'short_question',
                    ];
                    QuestionPaper::updateOrCreate($data);
                    $j += $value->mark;
                }
            }
        }

        foreach ($quesMarks as $k => $v) {
            $questions = Question::whereExam_id($request->exam_id)
                                ->whereSubject_id($request->subject_id)
                                ->where('chapter_id', $v->chapter_id)
                                ->whereType('long_question')
                                ->inRandomOrder()
                                ->get();

            $k=0;
            foreach ($questions as $key => $value) {
                if ($k < $v->long) {
                    $data=[
                        'ques_info_id' => $questionInfo->id,
                        'question_id' => $value->id,
                        'type' => 'long_question',
                    ];
                    QuestionPaper::updateOrCreate($data);
                    $k += $value->mark;
                }
            }
        }

        try {
            toast('Success!', 'success');
            DB::commit();
            return redirect()->route('admin.generateQuestion.show', $questionInfo->id);
        } catch (\Exception $ex) {
            // return $ex->getMessage();
            toast('Error', 'error');
            DB::rollBack();
            return back();
        }
    }

    public function addQues(Request $request)
    {
        if(QuestionPaper::whereQues_info_id($request->ques_info_id)->whereIn('question_id',$request->question_id)->count() > 0){
            Alert::info('These questions already exist in this question paper');
            return back();
        }
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
            // return $ex->getMessage();
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

        if ($request->type == "multiple_choice") {
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
            }
        }

        try {
            DB::commit();
            toast('Success!', 'success');
            return redirect()->route('admin.generateQuestion.show', $request->quesInfoId);
        } catch (\Exception $ex) {
            // return $ex->getMessage();
            DB::rollBack();
            toast('error', 'Error');
            return redirect()->back();
        }
    }


    public function quesDestroy($quesId, $quesInfoId)
    {
        if ($error = $this->authorize('question-generate-delete')) {
            return $error;
        }
        try {
            QuestionPaper::whereQues_info_id($quesInfoId)->whereQuestion_id($quesId)->first()->delete();
            toast('Success!', 'success');
            return back();
        } catch (\Exception $ex) {
            toast('Error', 'error');
            return redirect()->back();
        }
    }

    public function quesInfoQuesDestroy($id)
    {
        if ($error = $this->authorize('question-generate-delete')) {
            return $error;
        }
        try {
            QuesInfo::whereExam_id($id)->whereStatus('Pending')->delete();
            toast('Success!', 'success');
            return back();
        } catch (\Exception $ex) {
            // // return $ex->getMessage();
            toast('Error', 'error');
            return redirect()->back();
        }
    }
}
