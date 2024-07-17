<?php

namespace App\Http\Controllers\Admin;

use FontLib\Font;
use Carbon\Carbon;
use App\Models\QuesInfo;
use Illuminate\Http\Request;
use App\Models\QuestionPaper;
use App\Models\MarkDistribution;
use PDF;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class QuestionPaperController extends Controller
{
    public function index(Request $request)
    {
        if ($error = $this->authorize('question-paper-manage')) {
            return $error;
        }
        if ($request->ajax()) {
            $queInfos = QuesInfo::with(['exam:id,name', 'subject:id,name'])
                ->whereStatus('Created')
                ->latest();

            return DataTables::of($queInfos)
                ->addIndexColumn()
                ->addColumn('date', function ($row) {
                    return bdDate($row->date);
                })
                ->addColumn('time', function ($row) {
                    return time12($row->time);
                })
                ->addColumn('duration', function ($row) {
                    return $row->d_hour . ':' . $row->d_minute . ' Minute';
                })
                // ->addColumn('content', function ($row) {
                //     return '<textarea class="form-control">'.strip_tags($row->content).'</textarea>';
                // })
                ->addColumn('set', function ($row) {
                    $badgeColors = [
                        'badge-primary',
                        'badge-secondary',
                        'badge-success',
                        'badge-danger',
                        'badge-info',
                    ];
                    $btn = '';
                    for ($i = 1; $i <= 5; $i++) {
                        $colorIndex = ($i - 1) % count($badgeColors);
                        $colorClass = $badgeColors[$colorIndex];

                        $btn .= '<a href="' . route('admin.generated_question.show', [$row->id, $i, 'show']) . '" class="badge ' . htmlspecialchars($colorClass) . ' mb-1">Set ' . quesSet($i) . '</a>';
                    }
                    return $btn;
                })
                // ->addColumn('generate', function ($row) {
                //     return '<a data-route="' . route('admin.generate_question.status', $row->id) . '" class="btn btn-primary text-light btn-sm" onclick="changeStatus(this)">Generate</a>';
                // })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    // if (userCan('slider-edit')) {
                    //     $btn .= view('button', ['type' => 'ajax-edit', 'route' => route('admin.sliders.edit', $row->id), 'row' => $row]);
                    // }
                    // if (userCan('slider-delete')) {
                    //     $btn .= view('button', ['type' => 'ajax-delete', 'route' => route('admin.sliders.destroy', $row->id), 'row' => $row, 'src' => 'dt']);
                    // }

                    return $btn;
                })
                ->rawColumns(['set', 'generate', 'action'])
                ->make(true);
        }
        return view('admin.question_paper.index');
    }

    // public function showBySubject($examId)
    // {
    //     $datum = QuesInfo::with(['exam'])->whereExam_id($examId)->whereStatus('Completed')->get();
    //     return view('admin.question_paper.subject_show', compact('datum'));
    // }

    // public function showBySet($subjectId, $year)
    // {
    //     $datum = QuesInfo::with(['exam'])->whereSubject_id($subjectId)->whereStatus('Completed')->whereYear('date', $year)->get();
    //     return view('admin.question_paper.set_show', compact('datum'));
    // }

    public function show($quesInfoId, $set, $type)
    {
        $data['quesInfo'] = QuesInfo::with(['exam:id,name', 'subject:id,name'])->find($quesInfoId);
        $data['chapters'] = QuestionPaper::with([
            'question:id,chapter_id,type,ques,image,mark',
            'question.chapter:id,name',
            'options'
        ])
            ->whereQuesInfoId($quesInfoId)
            ->whereSet($set)
            ->get()
            ->groupBy('question.chapter.name');

        $quesMarks = $data['chapters']->map(function ($questions) {
            return $questions->sum(function ($questionPaper) {
                return $questionPaper->question->mark;
            });
        })->values();
        $data['totalQuesMark'] = $quesMarks->sum();

        $marks = MarkDistribution::where('subject_id', $data['quesInfo']->subject->id)
            ->select('pass_mark', DB::raw('SUM(`multiple` + `sort` + `long`) as total_mark'))
            ->groupBy('pass_mark')
            ->first();

        $data['passMark'] = $marks->pass_mark ?? 0;
        $data['totalMark'] = $marks->total_mark ?? 0;
        if ($data['chapters']->count() <= 0) {
            Alert::error('No Data Found');
            return back();
        }
        if($type == 'show'){
            return view('admin.question_paper.show', $data);
        }elseif($type == 'pdf'){
            // return view('admin.question_paper.pdf', $data);
            $pdf = PDF::loadView('admin.question_paper.pdf', $data);
            return $pdf->download($data['quesInfo']->exam->name . ' - ' . $data['quesInfo']->subject->name . ' - ' . date('h:i:sa d-M-Y') . '.pdf');
        }
    }

    // public function pdf($quesInfoId, $set)
    // {
    //     $chapters = QuestionPaper::with(['quesInfo', 'quesInfo.exam', 'options', 'question.chapter'])
    //         ->join('questions', 'questions.id', '=', 'question_papers.question_id')
    //         ->whereQuesInfoId($quesInfoId)
    //         ->whereSet($set)
    //         ->groupBy('chapter_id');

    //     $mark = MarkDistribution::whereSubject_id($chapters->first()->first()->quesInfo->subject_id);
    //     $passMark = $mark->first(['pass_mark'])->pass_mark;
    //     $totalMark = $mark->sum('multiple') + $mark->sum('sort') + $mark->sum('long');
    //     if ($chapters->count() <= 0) {
    //         Alert::error('No Data Found');
    //         return back();
    //     }
    //     // return view('admin.question_paper.pdf', compact('chapters','passMark','totalMark'));
    //     $pdf = PDF::loadView('admin.question_paper.pdf', compact('chapters', 'passMark', 'totalMark'));
    //     return $pdf->download($chapters->first()->first()->quesInfo->exam->name . ' - ' . $chapters->first()->first()->question->subject->name . ' - ' . date('h:i:sa d-M-Y') . '.pdf');
    //     // return view('admin.question_paper.show', compact('questionPapers','passMark','totalMark'));
    // }
    public function destroy($id)
    {
        // if ($error = $this->authorize('question-paper-delete')) {
        //     return $error;
        // }
        try {
            QuesInfo::find($id)->delete();
            QuestionPaper::whereQues_info_id($id)->delete();
            toast('Success!', 'success');
            return back();
        } catch (\Exception $ex) {
            toast('Error', 'error');
            return redirect()->back();
        }
    }
}
