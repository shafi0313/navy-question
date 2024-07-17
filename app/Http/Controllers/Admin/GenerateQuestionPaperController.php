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
use App\Http\Requests\StoreQuesInfoRequest;

class GenerateQuestionPaperController extends Controller
{
    public function index()
    {
        if ($error = $this->authorize('question-generate-manage')) {
            return $error;
        }

        $datum = QuesInfo::with(['exam', 'subject'])->whereStatus('Pending')->get()->groupBy('exam_id');
        return view('admin.generate_question_paper.index', compact('datum'));
    }

    public function showBySubject($examId)
    {
        $datum = QuesInfo::with(['exam', 'subject'])->whereExam_id($examId)->whereStatus('Pending')->get();
        return view('admin.generate_question_paper.subject_show', compact('datum'));
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
            $questions = Question::whereNotIn('id', $request->quesId)->whereChapter_id($request->chapterId)->whereType($request->quesType)->get();
            return response()->json(['questions' => $questions, 'status' => 200]);
        }
    }

    public function store(Request $request, StoreQuesInfoRequest $quesInfoRequest)
    {
        if ($error = $this->authorize('question-generate-add')) {
            return $error;
        }
        DB::beginTransaction();

        $questionInfoIds = [];
        for ($time = 1; $time <= 5; $time++) {
            $quesInfo = $quesInfoRequest->validated();
            $quesInfo['status'] = 'Pending';
            $quesInfo['user_id'] = auth()->user()->id;
            $quesInfo['set'] = $time;
            // $quesInfo['set'] = QuesInfo::whereYear('date', now('Y'))->whereExamId($quesInfoRequest->exam_id)->whereSubjectId($quesInfoRequest->subject_id)->count() + 1;
            $quesMarks = MarkDistribution::whereSubject_id($quesInfoRequest->subject_id)->get();
            // Mark Distribution Check
            if ($quesMarks->count() < 1) {
                Alert::info('At first, distribute the subject marks then generate the question');
                return back();
            }
            // Question Count Check
            if (Question::whereExamId($quesInfoRequest->exam_id)->whereSubjectId($quesInfoRequest->subject_id)->whereIn('chapter_id', $quesMarks->pluck('chapter_id'))->get()->count() < 1) {
                Alert::info('No Data Found');
                return back();
            }

            $questionInfo = QuesInfo::create($quesInfo);
            $questionInfoIds[] = $questionInfo->id;

            foreach ($quesMarks as $k => $v) {
                $questions = Question::whereExam_id($quesInfoRequest->exam_id)
                    ->whereSubject_id($quesInfoRequest->subject_id)
                    ->where('chapter_id', $v->chapter_id)
                    ->whereType('multiple_choice')
                    ->inRandomOrder()
                    ->get();
                $i = 0;
                foreach ($questions as $key => $value) {
                    if ($i < $v->multiple) {
                        $data = [
                            'ques_info_id' => $questionInfo->id,
                            'question_id'  => $value->id,
                            'type'         => 'multiple_choice',
                        ];
                        QuestionPaper::updateOrCreate($data);
                        $i += $value->mark;
                    }
                }
            }

            foreach ($quesMarks as $k => $v) {
                $questions = Question::whereExam_id($quesInfoRequest->exam_id)
                    ->whereSubject_id($quesInfoRequest->subject_id)
                    ->where('chapter_id', $v->chapter_id)
                    ->whereType('short_question')
                    ->inRandomOrder()
                    ->get();
                $j = 0;
                foreach ($questions as $key => $value) {
                    if ($j < $v->sort) {
                        $data = [
                            'ques_info_id' => $questionInfo->id,
                            'question_id'  => $value->id,
                            'type'         => 'short_question',
                        ];
                        QuestionPaper::updateOrCreate($data);
                        $j += $value->mark;
                    }
                }
            }

            foreach ($quesMarks as $k => $v) {
                $questions = Question::whereExam_id($quesInfoRequest->exam_id)
                    ->whereSubject_id($quesInfoRequest->subject_id)
                    ->where('chapter_id', $v->chapter_id)
                    ->whereType('long_question')
                    ->inRandomOrder()
                    ->get();

                $k = 0;
                foreach ($questions as $key => $value) {
                    if ($k < $v->long) {
                        $data = [
                            'ques_info_id' => $questionInfo->id,
                            'question_id'  => $value->id,
                            'type'         => 'long_question',
                        ];
                        QuestionPaper::updateOrCreate($data);
                        $k += $value->mark;
                    }
                }
            }
        }

        try {
            toast('Success!', 'success');
            DB::commit();
            $questionInfoIdsString = implode(',', $questionInfoIds);
            return redirect()->route('admin.generateQuestion.show', ['ids' => $questionInfoIdsString]);
        } catch (\Exception $ex) {
            return $ex->getMessage();
            toast('Error', 'error');
            DB::rollBack();
            return back();
        }
    }

    public function show($quesInfoIds)
    {
        $chapters = QuestionPaper::with(['quesInfo', 'options', 'question.chapter'])
            ->join('questions', 'questions.id', '=', 'question_papers.question_id')
            ->whereQues_info_id($quesInfoIds)
            ->get()
            ->groupBy('chapter_id');

            $questionInfoIds = explode(',', $quesInfoIds);
            $quesInfos = QuesInfo::with(['questionPapers','questionPapers.options','questionPapers.question', 'questionPapers.question.chapter'])
            ->whereIn('id',$questionInfoIds)
            ->get()->groupBy('set');

        if ($chapters->count() < 1) {
            Alert::info('No Data Found');
            return back();
        }
        $exams = Exam::all();
        $mainChapters = Chapter::whereSubject_id($chapters->first()->first()->question->subject_id)->get();
        return view('admin.generate_question_paper.show', compact('exams', 'mainChapters', 'chapters', 'quesInfoIds', 'quesInfos'));
    }

    public function addQues(Request $request)
    {
        if (QuestionPaper::whereQues_info_id($request->ques_info_id)->whereIn('question_id', $request->question_id)->count() > 0) {
            Alert::info('These questions already exist in this question paper');
            return back();
        }
        foreach ($request->question_id as $k => $v) {
            $data = [
                'ques_info_id' => $request->ques_info_id,
                'question_id'  => $request->question_id[$k],
                'type'         => $request->type,
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
            $quesInfo->update(['status' => 'Completed']);
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
            'type'       => 'required',
            'mark'       => 'required',
            'ques'       => 'required',
        ]);
        $data['user_id'] = auth()->user()->id;

        DB::beginTransaction();
        Question::find($quesId)->update($data);

        if ($request->type == "multiple_choice") {
            foreach ($request->option as $key => $value) {
                $option = [
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
