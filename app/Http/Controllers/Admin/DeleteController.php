<?php

namespace App\Http\Controllers\Admin;

use App\Models\Question;
use App\Models\QuestionInfo;
use App\Models\QuestionPaper;
use App\Models\QuestionSubjectInfo;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class DeleteController extends Controller
{
    public function index()
    {
        $data['questions'] = Question::count();
        $data['draftQuestion'] = QuestionInfo::whereStatus(1)->count();
        $data['finalQuestion'] = QuestionInfo::whereStatus(2)->count();
        return view('admin.delete.index', $data);
    }

    public function question()
{
    DB::beginTransaction();
    try {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        $tables = [
            'question_papers',
            'question_subject_infos',
            'question_infos',
            'ques_options',
            'questions'
        ];

        foreach ($tables as $table) {
            DB::table($table)->delete(); // Use delete() instead of truncate()
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        DB::commit();
        Alert::success('Success', 'Draft Questions Deleted Successfully');
    } catch (\Exception $e) {
        DB::rollBack();
        Alert::error('Error', 'Something went wrong');
        return $e->getMessage();
    }

    return back();
}



    public function draftQues()
    {
        try {
            DB::transaction(function () {
                $draftQuestions = QuestionInfo::whereStatus(1);
                $questionSubjectInfos = QuestionSubjectInfo::whereIn('question_info_id', $draftQuestions->pluck('id'));
                QuestionPaper::whereIn('question_subject_info_id', $questionSubjectInfos->pluck('id'))->delete();
                $questionSubjectInfos->delete();
                $draftQuestions->delete();
            });
            Alert::success('Success', 'Draft Questions Deleted Successfully');
        } catch (\Exception $e) {
            Alert::error('Error', 'Something went wrong');
        }
        return back();
    }

    public function finalQues()
    {
        try {
            DB::transaction(function () {
                $draftQuestions = QuestionInfo::whereStatus(2);
                $questionSubjectInfos = QuestionSubjectInfo::whereIn('question_info_id', $draftQuestions->pluck('id'));
                QuestionPaper::whereIn('question_subject_info_id', $questionSubjectInfos->pluck('id'))->delete();
                $questionSubjectInfos->delete();
                $draftQuestions->delete();
            });
            Alert::success('Success', 'Draft Questions Deleted Successfully');
        } catch (\Exception $e) {
            return $e->getMessage();
            Alert::error('Error', 'Something went wrong');
        }
        return back();
    }
}
