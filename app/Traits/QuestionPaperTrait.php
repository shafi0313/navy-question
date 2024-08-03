<?php

namespace App\Traits;

use App\Models\QuesInfo;
use App\Models\QuestionInfo;
use App\Models\QuestionPaper;
use App\Models\MarkDistribution;
use App\Models\QuestionSubjectInfo;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

trait QuestionPaperTrait
{
    public function questionPaperShow($quesInfoId, $set, $type)
    {
        $data['questionInfo'] = QuestionInfo::with(['exam:id,name'])->find($quesInfoId);
        // return
        $data['questionSubjectInfos'] = QuestionSubjectInfo::with([
            'subject:id,name', 'questionPapers', 'questionPapers.question', 'questionPapers.options'
        ])
            ->whereQuestionInfoId($quesInfoId)
            ->get();




        // return $data['chapters'] = QuestionPaper::with([
        //     'question:id,chapter_id,type,ques,image,mark',
        //     'question.chapter:id,name',
        //     'options',
        // ])
        //     // ->whereQuestionInfoId($quesInfoId)
        //     ->whereSet($set)
        //     ->get()
        //     ->groupBy('question.chapter.name');

        // $quesMarks = $data['chapters']->map(function ($questions) {
        //     return $questions->sum(function ($questionPaper) {
        //         return $questionPaper->question->mark;
        //     });
        // })->values();
        // $data['totalQuesMark'] = $quesMarks->sum();

        // $marks = MarkDistribution::where('subject_id', $data['quesInfo']->subject->id)
        //     ->select('pass_mark', DB::raw('SUM(`multiple` + `sort` + `long`) as total_mark'))
        //     ->groupBy('pass_mark')
        //     ->first();

        // $data['passMark'] = $marks->pass_mark ?? 0;
        // $data['totalMark'] = $marks->total_mark ?? 0;
        // if ($data['chapters']->count() <= 0) {
        //     Alert::error('No Data Found');

        //     return back();
        // }

        return $data;
    }
}
