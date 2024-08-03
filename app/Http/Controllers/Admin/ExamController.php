<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Subject;
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
            $exams = Exam::query();

            return DataTables::of($exams)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->diffForHumans();
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if (userCan('exam-edit')) {
                        $btn .= view('button', ['type' => 'ajax-edit', 'route' => route('admin.exam.edit', $row->id), 'row' => $row]);
                    }
                    if (userCan('exam-delete')) {
                        $btn .= view('button', ['type' => 'ajax-delete', 'route' => route('admin.exam.destroy', $row->id), 'row' => $row, 'src' => 'dt']);
                    }

                    return $btn;
                })
                ->rawColumns(['check', 'action', 'created_at'])
                ->make(true);
        }

        return view('admin.exam.index');
    }

    // public function create()
    // {
    //     if ($error = $this->authorize('exam-add')) {
    //         return $error;
    //     }
    //     $subjects = Subject::all();
    //     return view('admin.exam.create', compact('subjects'));
    // }

    public function store(Request $request)
    {
        if ($error = $this->authorize('exam-add')) {
            return $error;
        }
        $data = $this->validate($request, [
            'name' => 'required|max:100',
        ]);
        $data['user_id'] = auth()->user()->id;
        DB::beginTransaction();
        try {
            Exam::create($data);
            DB::commit();

            return response()->json(['message' => 'Data Successfully Inserted'], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['message' => __('app.oops')], 500);
            // return response()->json(['message'=>$e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Exam $exam)
    {
        // if ($error = $this->authorize('class-room-edit')) {
        //     return $error;
        // }
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
        $data['user_id'] = auth()->user()->id;
        DB::beginTransaction();
        try {
            $exam->update($data);
            DB::commit();

            return response()->json(['message' => 'Data Successfully Inserted'], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['message' => __('app.oops')], 500);
            // return response()->json(['message'=>$e->getMessage()], 500);
        }
    }

    public function destroy(Exam $exam)
    {
        if ($error = $this->authorize('exam-delete')) {
            return $error;
        }
        try {
            $exam->delete();

            return response()->json(['message' => 'ClassRoom Deleted Successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => __('app.oops')], 500);
            // return response()->json(['message'=>$e->getMessage()], 500);
        }
    }
}
