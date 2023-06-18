<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exam;
use App\Models\Chapter;
use App\Models\Subject;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $data['examCount']         = Exam::count();
        $data['subjectCount']      = Subject::count();
        $data['chapterCount']      = Chapter::count();
        $data['quesCount']         = Question::count();
        $data['multipleQuesCount'] = Question::whereType('multiple_choice')->count();
        $data['shortQuesCount']    = Question::whereType('short_question')->count();
        $data['longQuesCount']     = Question::whereType('long_question')->count();
        return view('admin.dashboard', $data);
    }
}
