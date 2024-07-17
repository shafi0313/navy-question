<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Enroll;
use App\Models\Exam;
use App\Models\QuesAns;
use App\Models\QuestionPaper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class GeneratedQuesController extends Controller
{
    public function index()
    {
        $exams = Exam::with(['questionPaper'])->get();

        return view('user.generated_ques.index', compact('exams'));
    }

    public function show($examId)
    {
        $exam = Exam::with('ans')->whereId($examId)->first();
        if (Carbon::parse($exam->date) <= Carbon::now()) {
        } else {
            Alert::info('The exam did not start');

            return back();
        }
        if ($exam->ans) {
            Alert::info('You have completed the exam');

            return back();
        }
        $questions = QuestionPaper::with(['options'])->whereExam_id($examId)->get();
        $questionPapers = QuestionPaper::with(['options'])->whereExam_id($examId)->get();

        return view('user.generated_ques.show', compact('questions', 'questionPapers'));
    }

    public function enroll(Request $request)
    {
        try {
            Enroll::create(['user_id' => auth()->user()->id, 'exam_id' => $request->exam_id]);
            Alert::success('Success');

            return back();
        } catch (\Exception $e) {
            return $e->getMessage();
            Alert::error('Failed');

            return back();
        }
    }

    public function store(Request $request)
    {
        foreach ($request->ans as $key => $value) {
            $data = [
                'user_id' => auth()->user()->id,
                'exam_id' => $request->exam_id,
                'question_id' => $request->question_id[$key],
                'ans' => $request->ans[$key],
            ];
            QuesAns::create($data);
        }
        try {
            Alert::success('Success');

            return redirect()->route('user.dashboard');
        } catch (\Exception $e) {
            return $e->getMessage();
            Alert::success('Failed');
            // return redirect()->route('user.dashboard');
        }
    }
}
