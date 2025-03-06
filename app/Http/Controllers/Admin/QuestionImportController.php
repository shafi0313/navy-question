<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuestionImportRequest;
use App\Http\Requests\UpdateQuestionImportRequest;
use App\Imports\QuesImport;
use App\Models\QuesOption;
use App\Models\Question;
use App\Models\QuestionImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class QuestionImportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = QuestionImport::paginate(30);

        return view('admin.question-import.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        try {
            Excel::import(new QuesImport, $request->file('file'));
            Alert::success('Question imported successfully!');
        } catch (\Exception $e) {
            Alert::error('Something went wrong!, Please try again.');
        }

        return back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuestionImportRequest $request)
    {
        $request = $request->validated();
        $questions = QuestionImport::select('id', 'ques', 'option_1', 'option_2', 'option_3', 'option_4', 'mark', 'correct')->get();

        DB::beginTransaction();
        foreach ($questions as $question) {
            $existingQuestion = Question::where('ques', $question->ques)
                ->where('rank_id', $request['rank_id'])
                ->where('subject_id', $request['subject_id'])
                ->where('type', $request['type'])
                ->first();

            // If the question already exists, skip to the next iteration
            if ($existingQuestion) {
                continue;
            }
            $quesData = Question::create([
                'rank_id' => $request['rank_id'],
                'subject_id' => $request['subject_id'],
                'type' => $request['type'],
                'ques' => $question->ques,
                'mark' => $question->mark,
            ]);

            $options = [
                $question->option_1,
                $question->option_2,
                $question->option_3,
                $question->option_4,
            ];

            $correctAnswerIndex = (int) $question->correct - 1;

            foreach ($options as $key => $option) {
                $correct = ($key === $correctAnswerIndex) ? 1 : 0;

                if ($option) {
                    QuesOption::create([
                        'question_id' => $quesData->id,
                        'option' => $option,
                        'correct' => $correct,
                    ]);
                }
            }
            QuestionImport::findOrFail($question->id)->delete();
        }

        try {
            DB::commit();
            $importQues = QuestionImport::all();
            if ($importQues->count() > 0) {
                Alert::info('There are some duplicate questions here, which have not been posted.');
            } else {
                Alert::success('Question added successfully!');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Something went wrong!, Please try again.');
        }

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(QuestionImport $questionImport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QuestionImport $questionImport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuestionImportRequest $request, QuestionImport $questionImport)
    {
        //
    }

    public function allDelete()
    {
        try {
            QuestionImport::truncate();
            Alert::success('Question deleted successfully!');
        } catch (\Exception $e) {
            Alert::error('Something went wrong!, Please try again.');
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuestionImport $questionImport)
    {
        try {
            $questionImport->delete();
            Alert::success('All question deleted successfully!');
        } catch (\Exception $e) {
            Alert::error('Something went wrong!, Please try again.');
        }

        return back();
    }
}
