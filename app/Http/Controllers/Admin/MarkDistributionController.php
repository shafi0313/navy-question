<?php

namespace App\Http\Controllers\Admin;

use App\Models\Chapter;
use App\Models\Subject;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\MarkDistribution;
use App\Http\Controllers\Controller;

class MarkDistributionController extends Controller
{
    public function index()
    {
        if ($error = $this->authorize('mark-distribution-manage')) {
            return $error;
        }
        $subjects = Subject::with('exam')->get();
        return view('admin.mark_distribution.index', compact('subjects'));
    }

    public function show($subjectId)
    {
        $subject = Subject::find($subjectId);
        $chapters = Chapter::with(['markDistribution'])->withCount('question')->whereSubject_id($subjectId)->get();
        return view('admin.mark_distribution.show', compact('subject','chapters'));
    }

    public function create()
    {
        if ($error = $this->authorize('mark-distribution-add')) {
            return $error;
        }

        $questions = Question::all();
        $subjects = Subject::all();
        return view('admin.mark_distribution.create', compact('questions','subjects'));
    }

    public function store(Request $request)
    {
        if ($error = $this->authorize('mark-distribution-add')) {
            return $error;
        }
        foreach($request->chapter_id as $k => $v) {
            $data=[
                'user_id' => auth()->user()->id,
                'subject_id' => $request->subject_id,
                'chapter_id' => $request->chapter_id[$k],
                'multiple' => $request->multiple[$k],
                'sort' => $request->sort[$k],
                'long' => $request->long[$k],
                'pass_mark' => $request->pass_mark,
            ];
            MarkDistribution::updateOrCreate(['subject_id'=>$request->subject_id,'chapter_id'=>$request->chapter_id[$k]],$data);
        }

        try {

            toast('Success!', 'success');
            return redirect()->route('admin.markDistribution.index');
        } catch (\Exception $ex) {
            // return $ex->getMessage();
            toast('Error', 'error');
            // return back();
        }
    }

    public function getMarkInfo(Request $request)
    {
        if ($request->ajax()) {
            $markDistribution = MarkDistribution::whereChapter_id($request->id)->whereSubject_id($request->subjectId)->get();
            return response()->json(['markDistribution'=>$markDistribution,'status'=>200]);
        }
    }
}
