<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\QuesInfo;
use Illuminate\Http\Request;
use App\Models\QuestionPaper;
use App\Models\MarkDistribution;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade as PDF;
use FontLib\Font;

class QuestionPaperController extends Controller
{
    public function index()
    {
        if ($error = $this->authorize('question-paper-manage')) {
            return $error;
        }
        // $datum = QuesInfo::with(['exam'])->select('*', DB::raw('DATE_FORMAT(date, "%Y") as date'))->whereStatus('Completed')->get()->groupBy('date');
        $datum = QuesInfo::with(['exam'])->whereStatus('Completed')->get()->groupBy('exam_id');
        return view('admin.question_paper.index', compact('datum'));
    }

    public function showBySubject($examId)
    {
        $datum = QuesInfo::with(['exam'])->whereExam_id($examId)->whereStatus('Completed')->get();
        return view('admin.question_paper.subject_show', compact('datum'));
    }

    public function showBySet($subjectId, $year)
    {
        // $datum = QuesInfo::with(['exam'])->whereSet($set)->get();
        $datum = QuesInfo::with(['exam'])->whereSubject_id($subjectId)->whereStatus('Completed')->whereYear('date', $year)->get();
        return view('admin.question_paper.set_show', compact('datum'));
    }

    public function show($quesInfoId)
    {
        $chapters = QuestionPaper::with(['quesInfo','options','subject','question.chapter'])
                            ->join('questions','questions.id', '=', 'question_papers.question_id')
                            ->whereQues_info_id($quesInfoId)
                            ->get()
                            ->groupBy('chapter_id');

        $mark = MarkDistribution::whereSubject_id($chapters->first()->first()->quesInfo->subject_id);
        $passMark = $mark->first(['pass_mark'])->pass_mark;
        $totalMark = $mark->sum('multiple') + $mark->sum('sort') + $mark->sum('long');
        if ($chapters->count() <= 0) {
            Alert::error('No Data Found');
            return back();
        }
        return view('admin.question_paper.show', compact('chapters', 'passMark', 'totalMark'));
    }

    public function pdf($quesInfoId)
    {
        $chapters = QuestionPaper::with(['quesInfo','quesInfo.exam','options','question.chapter'])
                            ->join('questions','questions.id', '=', 'question_papers.question_id')
                            ->whereQues_info_id($quesInfoId)
                            ->get()
                            ->groupBy('chapter_id');

        // return$chapters = QuestionPaper::with(['quesInfo','question'])->whereQues_info_id($quesInfoId)->get();
        $mark = MarkDistribution::whereSubject_id($chapters->first()->first()->quesInfo->subject_id);
        $passMark = $mark->first(['pass_mark'])->pass_mark;
        $totalMark = $mark->sum('multiple') + $mark->sum('sort') + $mark->sum('long');
        if ($chapters->count() <= 0) {
            Alert::error('No Data Found');
            return back();
        }
        // return view('admin.question_paper.pdf', compact('chapters','passMark','totalMark'));
        $pdf = PDF::loadView('admin.question_paper.pdf', compact('chapters', 'passMark', 'totalMark'));
        return $pdf->download($chapters->first()->first()->quesInfo->exam->name .' - '. $chapters->first()->first()->question->subject->name .' - '. date('h:i:sa d-M-Y') .'.pdf');
        // return view('admin.question_paper.show', compact('questionPapers','passMark','totalMark'));
    }
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
