<?php

namespace App\Http\Controllers\Admin;

use App\Models\Question;
use App\Models\QuesOption;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        if ($error = $this->authorize('question-entry-manage')) {
            return $error;
        }
        // return $questions = Question::with([
        //     'exam:id,name',
        //     'rank:id,name',
        //     'subject:id,name',
        //     // 'options:id,question_id,option',
        //     ])->get();
        if ($request->ajax()) {
            $questions = Question::with([
                'rank:id,name',
                'subject:id,name',
                // Uncomment the following line if options are needed
                // 'options:id,question_id,option',
            ]);

            return DataTables::of($questions)
                ->addIndexColumn()
                ->addColumn('type', function ($row) {
                    return Str::title(str_replace('_', ' ', $row->type));
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if (userCan('question-entry-edit')) {
                        $btn .= view('button', [
                            'type' => 'edit',
                            'route' => 'admin.questions',
                            $row->id,
                            'row' => $row
                        ]);
                    }
                    if (userCan('question-entry-delete')) {
                        $btn .= view('button', [
                            'type' => 'ajax-delete',
                            'route' => route('admin.questions.destroy', $row->id),
                            'row' => $row,
                            'src' => 'dt'
                        ]);
                    }
                    return $btn;
                })
                ->filter(function ($query) use ($request) {
                    // Apply filters based on exam_id, subject_id, rank_id
                    // if ($request->filled('exam_id')) {
                    //     $query->whereHas('exam', function ($q) use ($request) {
                    //         $q->where('exams.id', $request->exam_id);
                    //     });
                    // }
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
                ->rawColumns(['action'])
                ->make(true);
        }


        return view('admin.question_entry.index');
    }

    public function create()
    {
        if ($error = $this->authorize('question-entry-add')) {
            return $error;
        }
        return view('admin.question_entry.create');
    }

    public function store(StoreQuestionRequest $request)
    {
        if ($error = $this->authorize('question-entry-add')) {
            return $error;
        }
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = imgProcessAndStore($request->file('image'), 'question');
        }

        $questionEntry = Question::create($data);
        if ($request->type == 'multiple_choice') {
            foreach ($request->option as $key => $value) {
                $option = [
                    'question_id' => $questionEntry->id,
                    'option' => $request->option[$key],
                ];
                QuesOption::create($option);
            }
        }

        return response()->json($questionEntry, 200);
    }

    public function edit($id)
    {
        if ($error = $this->authorize('question-entry-edit')) {
            return $error;
        }
        $question = Question::with([
            'rank:id,name',
            'subject:id,name',
            'options'
        ])->find($id);

        return view('admin.question_entry.edit', compact('question'));
    }

    public function update(UpdateQuestionRequest $request, $id)
    {
        if ($error = $this->authorize('question-entry-edit')) {
            return $error;
        }
        $data = $request->validated();

        DB::beginTransaction();
        
        if ($request->hasFile('image')) {
            $data['image'] = imgProcessAndStore($request->file('image'), 'question');
        }
        Question::find($id)->update($data);

        if ($request->type == 'multiple_choice') {
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

    public function destroy($id)
    {
        if ($error = $this->authorize('question-entry-delete')) {
            return $error;
        }
        $user = Question::find($id);
        QuesOption::whereQuestion_id($id)->delete();
        $path = public_path('uploads/images/users/' . $user->image);
        if (file_exists($path) && ! is_null($user->image)) {
            unlink($path);
            $user->delete();
            QuesOption::whereQuestion_id($id)->delete();
            toast('Successfully Deleted', 'success');

            return redirect()->back();
        } else {
            $user->delete();
            QuesOption::whereQuestion_id($id)->delete();
            toast('Successfully Deleted', 'success');

            return redirect()->back();
        }
    }

    public function optionDestroy($id)
    {
        if ($error = $this->authorize('question-entry-delete')) {
            return $error;
        }
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
