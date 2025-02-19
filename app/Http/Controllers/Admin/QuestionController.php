<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\QuesOption;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $questions = Question::with([
                'rank:id,name',
                'subject:id,name',
                'options:id,question_id,option,correct',
            ]);

            return DataTables::of($questions)
                ->addIndexColumn()
                ->addColumn('options', function ($row) {
                    if ($row->type == 'multiple_choice') {
                        $options = '';
                        foreach ($row->options as $index => $option) {
                            $options .= '<p class="mb-2">';
                            $options .= $option->correct == 1
                                ? '<i class="fa-regular fa-circle-check"></i> '
                                : numberToBnWord($index + 1).') ';
                            $options .= $option->option.'</p>';
                        }

                        return $options;
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    $btn .= view('button', [
                        'type' => 'edit',
                        'route' => 'admin.questions',
                        $row->id,
                        'row' => $row,
                    ]);
                    $btn .= view('button', [
                        'type' => 'ajax-delete',
                        'route' => route('admin.questions.destroy', $row->id),
                        'row' => $row,
                        'src' => 'dt',
                    ]);

                    return $btn;
                })
                ->filter(function ($query) use ($request) {
                    if ($request->filled('subject_id')) {
                        $query->where('subject_id', $request->subject_id);
                    }
                    if ($request->filled('rank_id')) {
                        $query->where('rank_id', $request->rank_id);
                    }

                    // Apply search term filter
                    if ($search = $request->get('search')['value']) {
                        $query->where(function ($q) use ($search) {
                            $q->where('type', 'LIKE', "%{$search}%")
                                ->orWhere('ques', 'LIKE', "%{$search}%") // Searching in question text
                                ->orWhereHas('rank', function ($q) use ($search) {
                                    $q->where('name', 'LIKE', "%{$search}%");
                                })
                                ->orWhereHas('subject', function ($q) use ($search) {
                                    $q->where('name', 'LIKE', "%{$search}%");
                                });
                        });
                    }
                })
                ->rawColumns(['options', 'action'])
                ->make(true);
        }

        return view('admin.question_entry.index');
    }

    public function create()
    {
        return view('admin.question_entry.create');
    }

    public function store(StoreQuestionRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        if ($request->hasFile('image')) {
            $data['image'] = imgProcessAndStore($request->file('image'), 'question');
        }

        $questionEntry = Question::create($data);

        if ($request->type == 'multiple_choice') {
            if (! $request->option) {
                return response()->json(['message' => 'At least two options are required for multiple choice question'], 500);
            }
            foreach ($request->option as $key => $value) {
                $option = [
                    'question_id' => $questionEntry->id,
                    'option' => $request->option[$key],
                    'correct' => $request->correct[$key],
                ];
                QuesOption::create($option);
            }
        }

        try {
            DB::commit();

            return response()->json(['message' => 'The information has been inserted'], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['message' => 'Oops something went wrong, Please try again.'], 500);
        }
    }

    public function edit($id)
    {
        if ($error = $this->authorize('question-entry-edit')) {
            return $error;
        }
        $question = Question::with([
            'rank:id,name',
            'subject:id,name',
            'options',
        ])->find($id);

        return view('admin.question_entry.edit', compact('question'));
    }

    public function update(UpdateQuestionRequest $request, $id)
    {
        $data = $request->validated();

        DB::beginTransaction();

        if ($request->hasFile('image')) {
            $data['image'] = imgProcessAndStore($request->file('image'), 'question');
        }
        Question::find($id)->update($data);

        if ($request->type == 'multiple_choice') {
            if (! $request->option) {
                Alert::error('Success', 'At least two options are required for multiple choice question');

                return back();
            }
            foreach ($request->option as $key => $value) {
                $option = [
                    'question_id' => $id,
                    'option' => $request->option[$key],
                ];
                if (! empty(QuesOption::whereId($request->option_id[$key]))) {
                    QuesOption::where('id', $request->option_id[$key])->update($option);
                } else {
                    QuesOption::create($option);
                }
            }
        }

        try {
            DB::commit();
            Alert::success('Success', 'Data Successfully Updated');
        } catch (\Exception $ex) {
            DB::rollBack();
            Alert::error('Error', 'Failed to update data');
        }

        return back();
    }

    public function newOptionAdd(Request $request)
    {
        if ($error = $this->authorize('question-entry-edit')) {
            return $error;
        }
        $data = $this->validate($request, [
            'question_id' => 'required|integer',
            'option' => 'required',
        ]);
        try {
            QuesOption::create($data);
            Alert::success('Success', 'Data Successfully Inserted');
        } catch (\Exception $ex) {
            Alert::error('Error', 'Failed to insert data');
        }

        return back();
    }

    public function destroy(Question $question)
    {
        try {
            QuesOption::where('question_id', $question->id)->delete();
            imgUnlink('question', $question->image);
            $question->delete();

            return response()->json(['message' => 'The information has been deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Oops something went wrong, Please try again.'], 500);
        }
    }

    public function optionDestroy($id)
    {
        try {
            QuesOption::find($id)->delete();
            toast('Success!', 'success');

            return back();
        } catch (\Exception $e) {
            toast('Failed!', 'error');

            return back();
        }
    }
}
