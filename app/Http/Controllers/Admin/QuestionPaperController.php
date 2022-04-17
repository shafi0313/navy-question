<?php

namespace App\Http\Controllers\Admin;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class QuestionPaperController extends Controller
{
    public function index()
    {
        if ($error = $this->sendPermissionError('index')) {
            return $error;
        }
        $questions = Question::all();
        return view('admin.question_paper.index', compact('questions'));
    }

    public function show($examId)
    {
        if ($error = $this->sendPermissionError('show')) {
            return $error;
        }


        $questions = Question::with('options')->whereSelected(1)->whereExam_id($examId)->get();
        if($questions->count() <= 0 ){
            Alert::error('No Data Found');
            return back();
        }
        return view('admin.question_paper.show', compact('questions'));




    }
}
