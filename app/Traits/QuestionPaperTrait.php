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
        $data['questionInfo'] = QuestionInfo::with(['rank:id,name'])->find($quesInfoId);
        // return

        $customOrder = ['বাংলা', 'ইংরেজি', 'গণিত', 'বিজ্ঞান', 'সাধারণ জ্ঞান ও বুদ্ধিমত্তা'];
        $data['questionSubjectInfos'] = QuestionSubjectInfo::with([
            'subject' => function ($query) use ($customOrder) {
                $query->select('id', 'name')
                    ->orderByRaw("FIELD(name, '" . implode("','", $customOrder) . "')");
            },
            'questionPapers.question',
            'questionPapers.options',

            // 'markDistribution' => function ($query) {
            //     $query->select('subject_id', DB::raw('SUM(`multiple` + `sort` + `long`) as total_mark'))
            //         ->groupBy('subject_id');
            // },
        ])
            ->whereSet($set)
            ->where('question_info_id', $quesInfoId)
            ->get();

        return $data;
    }
}
