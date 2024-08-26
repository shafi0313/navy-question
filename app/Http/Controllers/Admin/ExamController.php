<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        if ($error = $this->authorize('exam-manage')) {
            return $error;
        }
        if ($request->ajax()) {
            $exams = Exam::with([
                'createdBy:id,name',
                'updatedBy:id,name'
            ])->orderBy('name');

            return DataTables::of($exams)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if (userCan('exam-edit')) {
                        $btn .= view('button', ['type' => 'ajax-edit', 'route' => route('admin.exams.edit', $row->id), 'row' => $row]);
                    }
                    if (userCan('exam-delete')) {
                        $btn .= view('button', ['type' => 'ajax-delete', 'route' => route('admin.exams.destroy', $row->id), 'row' => $row, 'src' => 'dt']);
                    }

                    return $btn;
                })
                ->rawColumns(['check', 'action', 'created_at'])
                ->make(true);
        }

        return view('admin.exam.index');
    }

    public function store(Request $request)
    {
        if ($error = $this->authorize('exam-add')) {
            return $error;
        }
        $data = $this->validate($request, [
            'name' => 'required|max:100',
        ]);
        $data['created_by'] = user()->id;
        try {
            Exam::create($data);
            return response()->json(['message' => 'The information has been inserted'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Oops something went wrong, Please try again.'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Exam $exam)
    {
        if ($error = $this->authorize('exam-edit')) {
            return $error;
        }
        if ($request->ajax()) {
            $modal = view('admin.exam.edit')->with('exam', $exam)->render();

            return response()->json(['modal' => $modal], 200);
        }

        return abort(500);
    }

    public function update(Request $request, Exam $exam)
    {
        if ($error = $this->authorize('exam-edit')) {
            return $error;
        }

        $data = $this->validate($request, [
            'name' => 'required|max:100',
        ]);
        $data['updated_by'] = user()->id;
        try {
            $exam->update($data);
            return response()->json(['message' => 'The information has been inserted'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Oops something went wrong, Please try again.'], 500);
        }
    }

    public function destroy(Exam $exam)
    {
        if ($error = $this->authorize('exam-delete')) {
            return $error;
        }
        try {
            $exam->delete();

            return response()->json(['message' => 'The information has been deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Oops something went wrong, Please try again.'], 500);
            // return response()->json(['message'=>$e->getMessage()], 500);
        }
    }
}
