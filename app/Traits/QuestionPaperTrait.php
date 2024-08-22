<?php

namespace App\Traits;

use App\Models\QuestionInfo;
use App\Models\QuestionSubjectInfo;
use Illuminate\Support\Facades\DB;

trait QuestionPaperTrait
{
    public function questionPaperShow($quesInfoId, $set, $type)
    {
        // return
        $data['questionInfo'] = QuestionInfo::with(['exam:id,name', 'rank:id,name'])->find($quesInfoId);
        // return
        $data['questionSubjectInfos'] = QuestionSubjectInfo::with([
            'subject:id,name',
            'questionPapers.question',
            'questionPapers.options',
            'markDistribution' => function ($query) {
                $query->select('subject_id', DB::raw('SUM(`multiple` + `sort` + `long`) as total_mark'))
                    ->groupBy('subject_id');
            },
        ])
            ->whereSet($set)
            ->where('question_info_id', $quesInfoId)
            ->get();

        return $data;
    }
}
