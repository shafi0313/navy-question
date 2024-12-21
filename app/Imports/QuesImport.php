<?php

namespace App\Imports;

use App\Models\QuestionImport;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class QuesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return QuestionImport::create([
            'ques'     => $row['question'],
            'option_1' => $row['option_1'],
            'option_2' => $row['option_2'],
            'option_3' => $row['option_3'],
            'option_4' => $row['option_4'],
            'mark'     => $row['mark'],
        ]);
    }
}
