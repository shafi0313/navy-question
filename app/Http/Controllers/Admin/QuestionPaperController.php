<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\QuesInfo;
use Illuminate\Http\Request;
use App\Models\QuestionPaper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class QuestionPaperController extends Controller
{
    public function index()
    {
        if ($error = $this->sendPermissionError('index')) {
            return $error;
        }
        $datum = QuesInfo::with(['exam'])->select('*',DB::raw('DATE_FORMAT(date_time, "%Y") as date'))->get()->groupBy('date');
        return view('admin.question_paper.index', compact('datum'));
    }

    public function show($year)
    {
        if ($error = $this->sendPermissionError('show')) {
            return $error;
        }
        $questionPapers = QuestionPaper::with(['exam','question'])->whereQues_info_id($year)->get();
        if($questionPapers->count() <= 0 ){
            Alert::error('No Data Found');
            return back();
        }
        return view('admin.question_paper.show', compact('questionPapers'));
    }
}
