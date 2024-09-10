<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exam;
use App\Models\Subject;
use App\Models\Question;
use App\Models\QuesOption;
use App\Models\QuestionInfo;
use Illuminate\Http\Request;
use App\Models\QuestionPaper;
use App\Models\MarkDistribution;
use App\Traits\QuestionPaperTrait;
use Illuminate\Support\Facades\DB;
use App\Models\QuestionSubjectInfo;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreQuestionInfoRequest;

class GenerateQuestionPaperController extends Controller
{
    use QuestionPaperTrait;

    public function index(Request $request)
    {
        if ($error = $this->authorize('question-generate-manage')) {
            return $error;
        }

        if ($request->ajax()) {
            $queInfos = QuestionInfo::with([
                'exam:id,name',
                'rank:id,name',
                'questionSubjectInfo'
            ])
                ->whereStatus('Pending')
                ->latest();

            return DataTables::of($queInfos)
                ->addIndexColumn()
                ->addColumn('date', function ($row) {
                    return bdDate($row->date);
                })
                ->addColumn('duration', function ($row) {
                    return $row->d_hour . ':' . $row->d_minute . ' Minute';
                })
                ->addColumn('set', function ($row) {
                    $badgeColors = [
                        'badge-danger',
                        'badge-primary',
                        'badge-warning',
                        'badge-primary',
                        'badge-info',
                        'badge-dark',
                    ];
                    $btn = '';
                    for ($i = 1; $i <= 6; $i++) {
                        $colorIndex = ($i - 1) % count($badgeColors);
                        $colorClass = $badgeColors[$colorIndex];
                        $btn .= '<a href="' . route('admin.generate_question.show', [$row->id, $i, 'show']) . '" class="badge ' . htmlspecialchars($colorClass) . ' mb-1">Set ' . questionSetInBangla($i) . '</a>';
                    }

                    return $btn;
                })
                ->addColumn('generate', function ($row) {
                    return '<a data-route="' . route('admin.generate_question.status', $row->id) . '" class="btn btn-primary text-light btn-sm" onclick="changeStatus(this)">Generate</a>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    // if (userCan('slider-edit')) {
                    //     $btn .= view('button', ['type' => 'ajax-edit', 'route' => route('admin.sliders.edit', $row->id), 'row' => $row]);
                    // }
                    if (userCan('question-generate-delete')) {
                        $btn .= view('button', ['type' => 'ajax-delete', 'route' => route('admin.generate_question.destroy', $row->id), 'row' => $row, 'src' => 'dt']);
                    }

                    return $btn;
                })
                ->rawColumns(['set', 'generate', 'action'])
                ->make(true);
        }

        return view('admin.generate_question_paper.index');
    }

    public function create()
    {
        if ($error = $this->authorize('question-generate-add')) {
            return $error;
        }

        return view('admin.generate_question_paper.create');
    }

    public function getQuestion(Request $request)
    {
        if ($request->ajax()) {
            $questions = Question::whereNotIn('id', $request->get_question_id)
                ->whereSubjectId($request->subject_id)
                ->whereRankId($request->rank_id)
                ->whereType($request->ques_type)
                ->get();

            return response()->json(['questions' => $questions, 'status' => 200]);
        }
    }

    public function store(Request $request, StoreQuestionInfoRequest $questionInfoRequest)
    {
        if ($error = $this->authorize('question-generate-add')) {
            return $error;
        }
        DB::beginTransaction();

        $data = $questionInfoRequest->validated();
        $data['status'] = 'Pending';

        $questionInfo = QuestionInfo::create($data);

        $getSubjects = Subject::whereExamId($request->exam_id)->get();
        for ($set = 1; $set <= 6; $set++) {
            foreach ($getSubjects as $getSubject) {
                $questionSubjectInfo = QuestionSubjectInfo::create([
                    'question_info_id' => $questionInfo->id,
                    'subject_id' => $getSubject->id,
                    'set' => $set,
                ]);
                $quesMarks = MarkDistribution::whereSubjectId($getSubject->id)->get();
                foreach ($quesMarks as $k => $v) {
                    $questions = Question::whereSubjectId($getSubject->id)
                        ->whereRankId($questionInfoRequest->rank_id)
                        // ->where('chapter_id', $v->chapter_id)
                        ->whereType('multiple_choice')
                        ->inRandomOrder()
                        ->get();
                    $i = 0;
                    foreach ($questions as $key => $value) {
                        if ($i < $v->multiple) {
                            $data = [
                                'question_subject_info_id' => $questionSubjectInfo->id,
                                'question_id' => $value->id,
                                'type' => 'multiple_choice',
                            ];
                            QuestionPaper::updateOrCreate($data);
                            $i += $value->mark;
                        }
                    }
                }

                foreach ($quesMarks as $k => $v) {
                    $questions = Question::whereSubjectId($getSubject->id)
                        ->whereRankId($questionInfoRequest->rank_id)
                        // ->where('chapter_id', $v->chapter_id)
                        ->whereType('short_question')
                        ->inRandomOrder()
                        ->get();
                    $j = 0;
                    foreach ($questions as $key => $value) {
                        if ($j < $v->sort) {
                            $data = [
                                'question_subject_info_id' => $questionSubjectInfo->id,
                                'question_id' => $value->id,
                                'type' => 'short_question',
                                // 'set' => $set,
                                // 'ques_no' => $quesNo,
                            ];
                            QuestionPaper::updateOrCreate($data);
                            $j += $value->mark;
                        }
                    }
                }

                foreach ($quesMarks as $k => $v) {
                    $questions = Question::whereSubjectId($getSubject->id)
                        ->whereRankId($questionInfoRequest->rank_id)
                        // ->where('chapter_id', $v->chapter_id)
                        ->whereType('long_question')
                        ->inRandomOrder()
                        ->get();

                    $k = 0;
                    foreach ($questions as $key => $value) {
                        if ($k < $v->long) {
                            $data = [
                                'question_subject_info_id' => $questionSubjectInfo->id,
                                'question_id' => $value->id,
                                'type' => 'long_question',
                                // 'set' => $set,
                                // 'ques_no' => $quesNo,
                            ];
                            QuestionPaper::updateOrCreate($data);
                            $k += $value->mark;
                        }
                    }
                }
            }
        }

        try {
            toast('Success!', 'success');
            DB::commit();

            // $questionInfoIdsString = implode(',', $questionInfoIds);
            // return redirect()->route('admin.generate_question.show', ['ids' => $questionInfoIdsString]);
            return redirect()->route('admin.generate_question.index');
        } catch (\Exception $ex) {
            return $ex->getMessage();
            toast('Error', 'error');
            DB::rollBack();

            return back();
        }
    }

    public function show($quesInfoId, $set, $type)
    {
        // return
        $data = $this->questionPaperShow($quesInfoId, $set, $type);
        $data['subjects'] = Subject::whereExamId($data['questionInfo']['exam_id'])->get();

        if ($type == 'show') {
            return view('admin.generate_question_paper.show', $data);
        }
    }

    public function status(QuestionInfo $quesInfo)
    {
        $quesInfo->status = 'Created';
        try {
            $quesInfo->save();

            return response()->json(['message' => 'The status has been updated'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Oops something went wrong, Please try again.'], 500);
        }
    }

    public function addQues(Request $request)
    {
        if (QuestionPaper::whereQuestionSubjectInfoId($request->question_subject_info_id)->whereIn('question_id', $request->question_id)->count() > 0) {
            Alert::info('These questions already exist in this question paper');

            return back();
        }
        foreach ($request->question_id as $k => $v) {
            $data = [
                'question_subject_info_id ' => $request->question_subject_info_id,
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

    // public function complete(Request $request)
    // {
    //     if ($error = $this->authorize('question-generate-generate')) {
    //         return $error;
    //     }
    //     $quesInfo = QuesInfo::find($request->quesInfoId);
    //     try {
    //         $quesInfo->update(['status' => 'Completed']);
    //         toast('Success!', 'success');
    //         return redirect()->route('admin.generate_question.showBySubject', Carbon::parse($quesInfo->date)->format('Y'));
    //     } catch (\Exception $ex) {
    //         toast('Error', 'error');
    //         return redirect()->back();
    //     }
    // }

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

        if ($request->type == 'multiple_choice') {
            foreach ($request->option as $key => $value) {
                $option = [
                    'question_id' => $quesId,
                    'option' => $request->option[$key],
                ];
                if (! empty(QuesOption::whereId($request->option_id[$key]))) {
                    QuesOption::where('id', $request->option_id[$key])->update($option);
                } else {
                    QuesOption::create($option);
                }
            }
        }

        try {
            DB::commit();
            toast('Success!', 'success');

            return redirect()->route('admin.generate_question.show', $request->quesInfoId);
        } catch (\Exception $ex) {
            // return $ex->getMessage();
            DB::rollBack();
            toast('error', 'Error');

            return redirect()->back();
        }
    }

    public function quesDestroy($quesPaperId)
    {
        if ($error = $this->authorize('question-generate-delete')) {
            return $error;
        }
        try {
            QuestionPaper::findOrFail($quesPaperId)->delete();
            toast('The information has been updated', 'success');
        } catch (\Exception $ex) {
            toast('Oops something went wrong, Please try again', 'error');
        }

        return back();
    }

    public function destroy($id)
    {
        if ($error = $this->authorize('question-generate-delete')) {
            return $error;
        }

        try {
            QuestionInfo::findOrFail($id)->delete();
            return response()->json(['message' => 'The information has been deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Oops something went wrong, Please try again'], 500);
        }
    }
}
