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

class QuestionPaperController extends Controller
{
    public function index()
    {
        if ($error = $this->authorize('question-paper-manage')) {
            return $error;
        }
        $datum = QuesInfo::with(['exam'])->select('*',DB::raw('DATE_FORMAT(date_time, "%Y") as date'))->whereStatus('Completed')->get()->groupBy('date');
        return view('admin.question_paper.index', compact('datum'));
    }

    public function showBySubject($year)
    {
        // $datum = QuesInfo::with(['exam'])->whereSet($set)->get();
        $datum = QuesInfo::with(['exam'])->whereYear('date_time',$year)->whereStatus('Completed')->get()->groupBy('subject_id');
        return view('admin.question_paper.subject_show', compact('datum'));
    }

    public function showBySet($subjectId,$year)
    {
        // $datum = QuesInfo::with(['exam'])->whereSet($set)->get();
        $datum = QuesInfo::with(['exam'])->whereSubject_id($subjectId)->whereStatus('Completed')->whereYear('date_time',$year)->get();
        return view('admin.question_paper.set_show', compact('datum'));
    }

    public function show($quesInfoId)
    {
        if ($error = $this->sendPermissionError('show')) {
            return $error;
        }
        $questionPapers = QuestionPaper::with(['quesInfo','question'])->whereQues_info_id($quesInfoId)->get();
        $mark = MarkDistribution::whereSubject_id($questionPapers->first()->quesInfo->subject_id);
        $passMark = $mark->first(['pass_mark'])->pass_mark;
        $totalMark = $mark->sum('multiple') + $mark->sum('sort') + $mark->sum('long');
        if($questionPapers->count() <= 0 ){
            Alert::error('No Data Found');
            return back();
        }
        return view('admin.question_paper.show', compact('questionPapers','passMark','totalMark'));
    }
}
