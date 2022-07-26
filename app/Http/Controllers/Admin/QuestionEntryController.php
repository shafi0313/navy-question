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

class QuestionEntryController extends Controller
{
    public function index()
    {
        if ($error = $this->authorize('question-entry-manage')) {
            return $error;
        }
        $exams = Exam::all();
        $questions = Question::all();
        $subjects = Subject::all();
        return view('admin.question_entry.index', compact('exams','questions','subjects'));
    }

    public function create()
    {
        if ($error = $this->authorize('question-entry-add')) {
            return $error;
        }
        $exams = Exam::all();
        $subjects = Subject::all();
        $chapters = Chapter::all();
        return view('admin.question_entry.create', compact('exams','subjects','chapters'));
    }

    public function read(Request $request)
    {
        $inputs = Question::whereSubject_id($request->subject_id)->whereChapter_id($request->chapter_id)->whereType($request->type)->get();
        $questions = view('admin.question_entry.ajax', ['inputs' => $inputs])->render();
        return response()->json(['status' => 'success', 'html' => $questions, 'questions']);
    }

    // public function store(Request $request)
    // {
    //     // return $request;
    //     if ($error = $this->sendPermissionError('create')) {
    //         return $error;
    //     }

    //     $data = $this->validate($request, [
    //         'exam_id' => 'required|integer',
    //         'subject_id' => 'required|integer',
    //         'chapter_id' => 'required|integer',
    //         'type' => 'required',
    //         'mark' => 'required',
    //         'ques' => 'required',
    //     ]);
    //     $data['user_id'] = auth()->user()->id;

    //     DB::beginTransaction();
    //     $question = Question::create($data);

    //     if($request->type == "Multiple Choice"){
    //         foreach($request->option as $key => $value){
    //             $option=[
    //                 'question_id' => $question->id,
    //                 'option' => $request->option[$key],
    //             ];
    //             QuesOption::create($option);
    //         }
    //     }

    //     try{
    //         DB::commit();
    //         toast('success','Success');
    //         return redirect()->back();
    //     }catch(\Exception $ex){
    //         return $ex->getMessage();
    //         DB::rollBack();
    //         toast('error','Error');
    //         return redirect()->back();
    //     }
    // }

    public function store(Request $request)
    {
        if ($error = $this->authorize('question-entry-add')) {
            return $error;
        }
        // return $request;
        $data = $this->validate($request, [
            'exam_id' => 'required|integer',
            'subject_id' => 'required|integer',
            'chapter_id' => 'required|integer',
            'type' => 'required',
            'mark' => 'required',
            'ques' => 'required',
        ]);

        if($request->hasFile('image')){
            // $files = TextWithSingleImg::wherePage('carPhotoEditing')->whereSec_name('pageHead')->first('image')->before;
            // $path =  public_path('uploads/images/page/'.$files);
            // file_exists($files)?unlink($path):'';

            // $path = public_path().'/uploads/images/question';
            // if (!file_exists($path)) {
            //     File::makeDirectory($path, 0777, true, true);
            // }
            $image = $request->file('image');
            $imageName = "question_".rand(0, 1000000).'.'.$image->getClientOriginalExtension();
            $request->image->move('uploads/images/question/', $imageName);
            $data['image'] = $imageName;
        }

        // $data['ques'] =$request->ques;
        $data['user_id'] = auth()->user()->id;
        $questionEntry = Question::create($data);
        if($request->type == "Multiple Choice"){
            foreach($request->option as $key => $value){
                $option=[
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
        return view('admin.question_entry.edit', compact('question','exams'));
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

        if($request->type == "Multiple Choice"){
            foreach($request->option as $key => $value){
                $option=[
                    'question_id' => $id,
                    'option' => $request->option[$key],
                ];
                if(!empty(QuesOption::whereId($request->option_id[$key]))){
                    QuesOption::where('id', $request->option_id[$key])->update($option);
                }else{
                    QuesOption::create($option);
                }
                // QuesOption::updateOrCreate(['id' => $request->option_id],$option);
                // $update = QuesOption::where('id', $request->option_id[$key])->update($option);
                // if(!$update){
                //     QuesOption::create($option);
                // }
            }
        }

        try{
            DB::commit();
            toast('Success!','success');
            return redirect()->back();
        }catch(\Exception $ex){
            return $ex->getMessage();
            DB::rollBack();
            toast('error','Error');
            return redirect()->back();
        }
    }


    public function destroy($id)
    {
        if ($error = $this->authorize('question-entry-delete')) {
            return $error;
        }
        $user = Question::find($id);
        $path =  public_path('uploads/images/users/'.$user->image);
        if(file_exists($path) && !is_null($user->image)){
            unlink($path);
            $user->delete();
            toast('Successfully Deleted','success');
            return redirect()->back();
        }else{
            $user->delete();
            toast('Successfully Deleted','success');
            return redirect()->back();
        }
    }
    public function optionDestroy($id)
    {
        if ($error = $this->authorize('question-entry-delete')) {
            return $error;
        }
        try{
            QuesOption::find($id)->delete();
            toast('Success!','success');
            return back();
        }catch(\Exception $e){
            toast('Failed!','error');
            return back();
        }
    }

    public function getChapter(Request $request)
    {
        if ($request->ajax()) {
            $chapters = Chapter::whereSubject_id($request->subjectId)->get();
            return response()->json(['chapters'=>$chapters,'status'=>200]);
        }
    }
}

