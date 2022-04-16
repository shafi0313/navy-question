<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Exam;
use App\Models\Enroll;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class GeneratedQuesController extends Controller
{
    public function index()
    {
        $questions = Question::with('enroll')->get();
        return view('user.generated_ques.index', compact('questions'));
    }

    public function show($examId)
    {
        $question = Question::with('options')->whereSelected(1)->whereExam_id($examId)->first();
        if(Carbon::parse($question->exam->date_time) <= Carbon::now()){

        }else{
            Alert::info('The exam did not begin');
            return back();
        }
        $questions = Question::with('options')->whereSelected(1)->whereExam_id($examId)->get();
        return view('user.generated_ques.show', compact('questions'));
    }

    public function enroll(Request $request)
    {
        try{
            Enroll::create(['user_id' => auth()->user()->id, 'exam_id' => $request->exam_id]);
            Alert::success('Success');
            return back();
        }catch(\Exception $e){
            return $e->getMessage();
            Alert::error('Failed');
            return back();
        }
    }
}
