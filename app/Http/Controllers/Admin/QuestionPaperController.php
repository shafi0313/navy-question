<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuesInfo;
use App\Models\QuestionInfo;
use App\Models\QuestionPaper;
use App\Traits\QuestionPaperTrait;
use Illuminate\Http\Request;
use PDF;
use Yajra\DataTables\Facades\DataTables;

class QuestionPaperController extends Controller
{
    use QuestionPaperTrait;

    public function index(Request $request)
    {
        if ($error = $this->authorize('question-paper-manage')) {
            return $error;
        }
        if ($request->ajax()) {
            $queInfos = QuestionInfo::with([
                'exam:id,name',
                'rank:id,name',
                'questionSubjectInfo'])
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
                    return $row->d_hour.':'.$row->d_minute.' Minute';
                })
                // ->addColumn('content', function ($row) {
                //     return '<textarea class="form-control">'.strip_tags($row->content).'</textarea>';
                // })
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
                        $btn .= '<a href="'.route('admin.generated_question.show', [$row->id, $i, 'show']).'" class="badge mb-1" style="background-color: '.htmlspecialchars($colorCode).'; color: white;">Set '.questionSetInBangla($i).'</a> ';
                    }

                    return $btn;
                })
                // ->addColumn('action', function ($row) {
                //     $btn = '';
                //     if (userCan('slider-edit')) {
                //         $btn .= view('button', ['type' => 'ajax-edit', 'route' => route('admin.sliders.edit', $row->id), 'row' => $row]);
                //     }
                //     if (userCan('slider-delete')) {
                //         $btn .= view('button', ['type' => 'ajax-delete', 'route' => route('admin.sliders.destroy', $row->id), 'row' => $row, 'src' => 'dt']);
                //     }

                //     return $btn;
                // })
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
        $data = $this->questionPaperShow($quesInfoId, $set, $type);

        if ($type == 'show') {
            return view('admin.question_paper.show', $data);
        } elseif ($type == 'pdf') {
            // return $data;
            // return view('admin.question_paper.pdf', $data);
            $pdf = PDF::loadView('admin.question_paper.pdf', $data);

            return $pdf->download($data['questionInfo']->exam->name.' - '.date('h:i:sa d-M-Y').'.pdf');
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
