<?php

namespace App\Traits;

use App\Models\QuesInfo;
use App\Models\QuestionPaper;
use App\Models\MarkDistribution;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

trait QuestionPaperTrait
{
    public function questionPaperShow($quesInfoId, $set, $type)
    {
        $data['quesInfo'] = QuesInfo::with(['exam:id,name', 'subject:id,name'])->find($quesInfoId);
        $data['chapters'] = QuestionPaper::with([
            'question:id,chapter_id,type,ques,image,mark',
            'question.chapter:id,name',
            'options'
        ])
            ->whereQuesInfoId($quesInfoId)
            ->whereSet($set)
            ->get()
            ->groupBy('question.chapter.name');

        $quesMarks = $data['chapters']->map(function ($questions) {
            return $questions->sum(function ($questionPaper) {
                return $questionPaper->question->mark;
            });
        })->values();
        $data['totalQuesMark'] = $quesMarks->sum();

        $marks = MarkDistribution::where('subject_id', $data['quesInfo']->subject->id)
            ->select('pass_mark', DB::raw('SUM(`multiple` + `sort` + `long`) as total_mark'))
            ->groupBy('pass_mark')
            ->first();

        $data['passMark'] = $marks->pass_mark ?? 0;
        $data['totalMark'] = $marks->total_mark ?? 0;
        if ($data['chapters']->count() <= 0) {
            Alert::error('No Data Found');
            return back();
        }
        return $data;
    }
}
