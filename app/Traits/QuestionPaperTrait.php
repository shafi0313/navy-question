<?php

namespace App\Traits;

use App\Models\QuestionInfo;
use App\Models\QuestionSubjectInfo;

trait QuestionPaperTrait
{
    public function questionPaperShow($quesInfoId, $set, $type)
    {
        $data['questionInfo'] = QuestionInfo::with(['rank:id,name'])->find($quesInfoId);

        $customOrder = ['বাংলা', 'গণিত', 'ইংরেজি', 'বিজ্ঞান', 'সাধারণ জ্ঞান ও বুদ্ধিমত্তা'];
        $orderByRaw = "FIELD(subjects.name, '".implode("','", $customOrder)."')";

        $data['questionSubjectInfos'] = QuestionSubjectInfo::with([
            'subject:id,name',
            'questionPapers.question',
            'questionPapers.options',
        ])
            ->whereSet($set)
            ->where('question_info_id', $quesInfoId)
            ->join('subjects', 'question_subject_infos.subject_id', '=', 'subjects.id')
            ->orderByRaw($orderByRaw)
            ->select('question_subject_infos.*')
            ->get();

        return $data;
    }
}
