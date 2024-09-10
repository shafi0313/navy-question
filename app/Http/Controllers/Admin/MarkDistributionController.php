<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exam;
use Illuminate\Http\Request;
use App\Models\MarkDistribution;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class MarkDistributionController extends Controller
{
    public function index(Request $request)
    {
        if ($error = $this->authorize('mark-distribution-manage')) {
            return $error;
        }
        if ($request->ajax()) {
            $exams = Exam::query();

            return DataTables::of($exams)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '';
                    $btn = '<a href="' . route('admin.mark-distributions.show', $row->id) . '" class="btn btn-link btn-primary btn-lg">Entry</a>';
                    return $btn;
                })
                ->rawColumns(['check', 'action', 'created_at'])
                ->make(true);
        }

        return view('admin.mark-distribution.index');
    }

    public function show($examId)
    {
        $exam = Exam::with([
            'subjects:id,exam_id,name',
            'subjects.markDistribution',
            'subjects.questions:id,subject_id,type,ques',
            ])->find($examId);
        return view('admin.mark-distribution.show', compact('exam'));
    }

    public function store(Request $request)
    {
        if ($error = $this->authorize('mark-distribution-add')) {
            return $error;
        }
        foreach ($request->subject_id as $k => $v) {
            $data = [
                'subject_id' => $request->subject_id[$k],
                'multiple' => $request->multiple[$k],
            ];
            MarkDistribution::updateOrCreate(['subject_id' => $request->subject_id[$k]], $data);
        }

        try {

            toast('Success!', 'success');
            return redirect()->route('admin.mark-distributions.index');
        } catch (\Exception $ex) {
            toast('Error', 'error');
            return back();
        }
    }

    public function getMarkInfo(Request $request)
    {
        if ($request->ajax()) {
            $markDistribution = MarkDistribution::whereChapter_id($request->id)->whereSubject_id($request->subjectId)->get();

            return response()->json(['markDistribution' => $markDistribution, 'status' => 200]);
        }
    }
}
