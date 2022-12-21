<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Subject;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $examCount = Exam::count();
        $subjectCount = Subject::count();
        $chapterCount = Chapter::count();
        $quesCount = Question::count();
        $multipleQuesCount = Question::whereType('multiple_choice')->count();
        $shortQuesCount = Question::whereType('short_question')->count();
        $longQuesCount = Question::whereType('long_question')->count();
        return view('admin.dashboard', compact('examCount','subjectCount','chapterCount','quesCount','multipleQuesCount','shortQuesCount','longQuesCount'));
    }
}
