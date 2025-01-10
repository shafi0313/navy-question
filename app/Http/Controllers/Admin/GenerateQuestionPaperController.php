<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuestionInfoRequest;
use App\Models\Exam;
use App\Models\MarkDistribution;
use App\Models\QuesOption;
use App\Models\Question;
use App\Models\QuestionInfo;
use App\Models\QuestionPaper;
use App\Models\QuestionSubjectInfo;
use App\Models\Subject;
use App\Traits\QuestionPaperTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class GenerateQuestionPaperController extends Controller
{
    use QuestionPaperTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $queInfos = QuestionInfo::with([
                'rank:id,name',
                'questionSubjectInfo',
            ])
                ->whereStatus(1)
                ->latest();

            return DataTables::of($queInfos)
                ->addIndexColumn()
                ->addColumn('date', function ($row) {
                    return bdDate($row->date);
                })
                ->addColumn('status', function ($row) {
                    return $row->status == 1 ? 'Draft' : 'Created';
                })
                ->addColumn('duration', function ($row) {
                    return $row->d_hour . ':' . $row->d_minute . ' Minute';
                })
                ->addColumn('set', function ($row) {
                    $setColorCodes = [
                        1 => '#dc3545', // Red (Bootstrap's badge-danger)
                        2 => '#6c757d', // Brown/Secondary
                        3 => '#ffc107', // Yellow (Bootstrap's badge-warning)
                        4 => '#007bff', // Blue (Bootstrap's badge-primary)
                        5 => '#6f42c1', // Purple (custom color)
                        6 => '#28a745', // Green (Bootstrap's badge-success)
                    ];

                    $btn = '';
                    for ($i = 1; $i <= 6; $i++) {
                        $colorCode = $setColorCodes[$i];
                        $btn .= '<a href="' . route('admin.generate_question.show', [$row->id, $i, 'show']) . '" class="badge mb-1" style="background-color: ' . htmlspecialchars($colorCode) . '; color: white;">Set ' . questionSetInBangla($i) . '</a> ';
                    }

                    return $btn;
                })
                // ->addColumn('generate', function ($row) {
                //     return '<a data-route="'.route('admin.generate_question.status', $row->id).'" class="btn btn-primary text-light btn-sm" onclick="changeStatus(this)">Generate</a>';
                // })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    // if (userCan('slider-edit')) {
                    //     $btn .= view('button', ['type' => 'ajax-edit', 'route' => route('admin.sliders.edit', $row->id), 'row' => $row]);
                    // }
                    $btn .= '<a data-route="' . route('admin.generate_question.status', $row->id) . '" class="btn btn-primary text-light btn-sm mb-2" onclick="changeStatus(this)">Generate</a>';
                    $btn .= view('button', ['type' => 'ajax-delete', 'route' => route('admin.generate_question.destroy', $row->id), 'row' => $row, 'src' => 'dt']);
                    return $btn;
                })
                ->rawColumns(['set', 'generate', 'action'])
                ->make(true);
        }

        return view('admin.generate_question_paper.index');
    }

    public function create()
    {
        return view('admin.generate_question_paper.create');
    }

    public function getQuestion(Request $request)
    {
        if ($request->ajax()) {
            $questions = Question::whereNotIn('id', $request->get('question_id'))
                ->where('subject_id', $request->get('subject_id'))
                ->where('rank_id', $request->get('rank_id'))
                ->get();

            return response()->json(['questions' => $questions, 'status' => 200]);
        }

        return response()->json(['message' => 'Invalid request'], 400);
    }



    /**
     * Retrieve subjects based on the rank ID from the request.
     *
     * This method handles AJAX requests to fetch subjects associated with a specific rank ID.
     * If the request is not an AJAX request, it returns an error response.
     *
     * @param \Illuminate\Http\Request $request The incoming request instance.
     * @return \Illuminate\Http\JsonResponse The JSON response containing subjects or an error message.
     */
    public function getSubject(Request $request)
    {
        if ($request->ajax()) {
            $subjects = Subject::whereRankId($request->rank_id)->get();
            return response()->json(['subjects' => $subjects, 'status' => 200]);
        }
        return response()->json(['message' => 'Invalid request'], 400);
    }

    public function store(Request $request, StoreQuestionInfoRequest $questionInfoRequest)
    {
        $data = $questionInfoRequest->validated();
        $data['status'] = 1;

        DB::beginTransaction();

        $questionInfo = QuestionInfo::create($data);

        // $getSubjects = Subject::whereRankId($request->rank_id)->get();
        for ($set = 1; $set <= 6; $set++) {
            foreach ($questionInfoRequest->subject_id as $sub_key => $subject_id) {
                $questionSubjectInfo = QuestionSubjectInfo::create([
                    'question_info_id' => $questionInfo->id,
                    'subject_id' => $subject_id,
                    'set' => $set,
                ]);
                // $quesMarks = MarkDistribution::whereSubjectId($subject_id)->get();
                // foreach ($quesMarks as $k => $v) {
                $questions = Question::whereRankId($questionInfoRequest->rank_id)                    
                    ->whereSubjectId($subject_id)
                    ->whereType('multiple_choice')
                    ->inRandomOrder()
                    ->get();

                $i = 0;
                foreach ($questions as $key => $value) {
                    // return $questionInfoRequest->mark[5];
                    if ($i < $questionInfoRequest->mark[$sub_key]) {
                        $data = [
                            'question_subject_info_id' => $questionSubjectInfo->id,
                            'question_id' => $value->id,
                            'type' => 'multiple_choice',
                        ];
                        QuestionPaper::updateOrCreate($data);
                        $i += $value->mark;
                    }
                }
                // }
            }
        }

        try {
            toast('Success!', 'success');
            DB::commit();

            return redirect()->route('admin.generate_question.index');
        } catch (\Exception $ex) {
            toast('Error', 'error');
            DB::rollBack();

            return back();
        }
    }

    public function show($quesInfoId, $set, $type)
    {
        $data = $this->questionPaperShow($quesInfoId, $set, $type);
        $data['subjects'] = Subject::whereRankId($data['questionInfo']['rank_id'])->get();
        $data['quesInfoId'] = $quesInfoId;
        $data['set'] = $set;

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
        $questionSubjectInfo = QuestionSubjectInfo::where('question_info_id', $request->question_info_id)
            ->where('subject_id', $request->subject_id)
            ->where('set', $request->set)
            ->first();

        if (QuestionPaper::whereQuestionSubjectInfoId($questionSubjectInfo->id)->whereIn('question_id', $request->question_id)->count() > 0) {
            Alert::info('These questions already exist in this question paper');

            return back();
        }
        foreach ($request->question_id as $k => $v) {
            $data = [
                'question_subject_info_id' => $questionSubjectInfo->id,
                'question_id' => $request->question_id[$k],
                'type' => 'multiple_choice',
            ];
            QuestionPaper::updateOrCreate($data);
        }
        try {
            toast('Success!', 'success');
            DB::commit();
        } catch (\Exception $ex) {
            toast('Error', 'error');
            DB::rollBack();
        }

        return back();
    }

    public function edit($id, $quesInfoId)
    {
        $question = Question::with('options')->find($id);
        $exams = Exam::all();

        return view('admin.generate_question_paper.edit', compact('question', 'exams', 'quesInfoId'));
    }

    public function update(Request $request, $quesId)
    {
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
            DB::rollBack();
            toast('error', 'Error');

            return redirect()->back();
        }
    }

    public function quesDestroy($quesPaperId)
    {
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
        try {
            QuestionInfo::findOrFail($id)->delete();

            return response()->json(['message' => 'The information has been deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Oops something went wrong, Please try again'], 500);
        }
    }
}
