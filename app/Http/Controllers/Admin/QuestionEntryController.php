<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exam;
use App\Models\Chapter;
use App\Models\Subject;
use App\Models\Question;
use App\Models\QuesOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\StoreQuestionRequest;

class QuestionEntryController extends Controller
{
    public function index()
    {
        if ($error = $this->authorize('question-entry-manage')) {
            return $error;
        }

        return view('admin.question_entry.index');
    }

    public function create()
    {
        if ($error = $this->authorize('question-entry-add')) {
            return $error;
        }
        // $exams = Exam::all();
        // $subjects = Subject::all();
        // $chapters = Chapter::all();

        return view('admin.question_entry.create');
    }

    public function read(Request $request)
    {
        $inputs = Question::whereSubjectId($request->subject_id)
            ->whereChapterId($request->chapter_id)
            ->whereType($request->type)
            ->get();
        if ($inputs->count() > 0) {
            $questions = view('admin.question_entry.ajax', ['inputs' => $inputs])->render();

            return response()->json(['status' => 'success', 'html' => $questions, 'questions']);
        } else {
            return response()->json(['status' => 'no', 'message' => 'No data found']);
        }
    }

    public function getQuestion(Request $request)
    {
        if ($request->ajax()) {
            $questions = Question::whereChapter_id($request->chapterId)->whereType($request->quesType)->get();

            return response()->json(['questions' => $questions, 'status' => 200]);
        }
    }

    public function store(StoreQuestionRequest $request)
    {
        if ($error = $this->authorize('question-entry-add')) {
            return $error;
        }
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'question_'.rand(0, 1000000).'.'.$image->getClientOriginalExtension();
            $request->image->move('uploads/images/question/', $imageName);
            $data['image'] = $imageName;
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
        $question = Question::with('options')->find($id);
        $exams = Exam::all();

        return view('admin.question_entry.edit', compact('question', 'exams'));
    }

    public function update(Request $request, $id)
    {
        if ($error = $this->authorize('question-entry-edit')) {
            return $error;
        }
        $data = $this->validate($request, [
            'exam_id' => 'required|integer',
            'subject_id' => 'required|integer',
            'chapter_id' => 'required|integer',
            'type' => 'required',
            'mark' => 'required',
            'ques' => 'required',
        ]);
        $data['user_id'] = auth()->user()->id;

        DB::beginTransaction();
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
                // QuesOption::updateOrCreate(['id' => $request->option_id],$option);
                // $update = QuesOption::where('id', $request->option_id[$key])->update($option);
                // if(!$update){
                //     QuesOption::create($option);
                // }
            }
        }

        try {
            DB::commit();
            toast('Success!', 'success');

            return redirect()->back();
        } catch (\Exception $ex) {
            // return $ex->getMessage();
            DB::rollBack();
            toast('error', 'Error');

            return redirect()->back();
        }
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
        DB::beginTransaction();
        try {
            QuesOption::create($data);
            DB::commit();
            toast('Success!', 'success');

            return redirect()->back();
        } catch (\Exception $ex) {
            // return $ex->getMessage();
            DB::rollBack();
            toast('Error', 'error');

            return back();
        }
    }

    public function destroy($id)
    {
        if ($error = $this->authorize('question-entry-delete')) {
            return $error;
        }
        $user = Question::find($id);
        QuesOption::whereQuestion_id($id)->delete();
        $path = public_path('uploads/images/users/'.$user->image);
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

    public function getChapter(Request $request)
    {
        if ($request->ajax()) {
            $chapters = Chapter::whereSubject_id($request->subjectId)->get();

            return response()->json(['chapters' => $chapters, 'status' => 200]);
        }
    }
}
