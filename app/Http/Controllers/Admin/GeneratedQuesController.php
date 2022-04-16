<?php

namespace App\Http\Controllers\Admin;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GeneratedQuesController extends Controller
{
    public function index()
    {
        if ($error = $this->sendPermissionError('index')) {
            return $error;
        }
        $questions = Question::all();
        return view('admin.generated_ques.index', compact('questions'));
    }

    public function show($examId)
    {
        if ($error = $this->sendPermissionError('show')) {
            return $error;
        }
        $questions = Question::with('options')->whereSelected(1)->whereExam_id($examId)->get();
        return view('admin.generated_ques.show', compact('questions'));
    }
}
