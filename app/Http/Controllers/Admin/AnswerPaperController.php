<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuesAns;
use Illuminate\Http\Request;

class AnswerPaperController extends Controller
{
    public function index()
    {
        if ($error = $this->authorize('ans-paper-manage')) {
            return $error;
        }
        $answerPapers = QuesAns::with(['user', 'exam', 'subject'])->get();

        return view('admin.answer_paper.index', compact('answerPapers'));
    }

    public function show($userId, $examId)
    {
        if ($error = $this->authorize('ans-paper-manage')) {
            return $error;
        }
        $answerPapers = QuesAns::whereUser_id($userId)->whereExam_id($examId)->get();

        return view('admin.answer_paper.show', compact('answerPapers'));
    }

    public function store(Request $request)
    {
        if ($error = $this->authorize('ans-paper-add')) {
            return $error;
        }
        foreach ($request->question_id as $key => $value) {
            $data = [
                // 'question_id' => $request->question_id[$key],
                'mark' => $request->mark[$key],
            ];
            QuesAns::whereId($request->question_id)->update($data);
        }
        try {
            toast('Success', 'success');

            return back();
        } catch (\Exception $e) {
            return $e->getMessage();

        }
    }
}
