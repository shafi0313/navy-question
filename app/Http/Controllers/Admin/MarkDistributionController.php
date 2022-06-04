<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subject;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\MarkDistribution;
use App\Http\Controllers\Controller;

class MarkDistributionController extends Controller
{
    public function index()
    {
        if ($error = $this->sendPermissionError('index')) {
            return $error;
        }
        $questions = Question::all();
        $subjects = Subject::all();
        return view('admin.mark_distribution.index', compact('questions','subjects'));
    }

    public function create()
    {
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }
        $questions = Question::all();
        $subjects = Subject::all();
        return view('admin.mark_distribution.create', compact('questions','subjects'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject_id' => 'required|integer',
            'chapter_id' => 'required|integer',
            'type' => 'required',
            'mark' => 'required',
        ]);
        $data['user_id'] = auth()->user()->id;

        try {
            MarkDistribution::create($data);
            toast('Success!', 'success');
            return redirect()->route('admin.markDistribution.index');
        } catch (\Exception $ex) {
            return $ex->getMessage();
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
