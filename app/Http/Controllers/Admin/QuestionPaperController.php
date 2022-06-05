<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exam;
use App\Models\QuesInfo;
use Illuminate\Http\Request;
use App\Models\QuestionPaper;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class QuestionPaperController extends Controller
{
    public function index()
    {
        if ($error = $this->sendPermissionError('index')) {
            return $error;
        }
        $datum = QuesInfo::with(['exam'])->get();
        return view('admin.question_paper.index', compact('datum'));
    }

    public function show($examId)
    {
        if ($error = $this->sendPermissionError('show')) {
            return $error;
        }
        $questionPapers = QuestionPaper::with(['exam','question'])->whereExam_id($examId)->get();
        if($questionPapers->count() <= 0 ){
            Alert::error('No Data Found');
            return back();
        }
        return view('admin.question_paper.show', compact('questionPapers'));
    }
}
