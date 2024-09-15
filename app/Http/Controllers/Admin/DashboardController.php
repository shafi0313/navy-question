<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Subject;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $data['examCount'] = Exam::count();
        $data['subjectCount'] = Subject::count();
        $data['quesCount'] = Question::count();
        $data['multipleQuesCount'] = Question::whereType('multiple_choice')->count();
        // $data['shortQuesCount'] = Question::whereType('short_question')->count();
        // $data['longQuesCount'] = Question::whereType('long_question')->count();

        return view('admin.dashboard', $data);
    }
}
