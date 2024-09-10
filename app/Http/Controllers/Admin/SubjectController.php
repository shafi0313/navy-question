<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        if ($error = $this->authorize('subject-manage')) {
            return $error;
        }
        if ($request->ajax()) {
            $subjects = Subject::with(['exam:id,name']);

            return DataTables::of($subjects)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if (userCan('subject-edit')) {
                        $btn .= view('button', ['type' => 'ajax-edit', 'route' => route('admin.subjects.edit', $row->id), 'row' => $row]);
                    }
                    if (userCan('subject-delete')) {
                        $btn .= view('button', ['type' => 'ajax-delete', 'route' => route('admin.subjects.destroy', $row->id), 'row' => $row, 'src' => 'dt']);
                    }

                    return $btn;
                })
                ->rawColumns(['check', 'action', 'created_at'])
                ->make(true);
        }

        return view('admin.subject.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubjectRequest $request)
    {
        if ($error = $this->authorize('subject-add')) {
            return $error;
        }
        $data = $request->validated();
        try {
            Subject::create($data);

            return response()->json(['message' => 'The information has been inserted'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Oops something went wrong, Please try again.'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Subject $subject)
    {
        if ($error = $this->authorize('subject-edit')) {
            return $error;
        }

        if ($request->ajax()) {
            $subject->load('exam:id,name');
            $modal = view('admin.subject.edit')->with(['subject' => $subject])->render();

            return response()->json(['modal' => $modal], 200);
        }

        return abort(500);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        if ($error = $this->authorize('subject-add')) {
            return $error;
        }

        $data = $request->validated();
        try {
            $subject->update($data);

            return response()->json(['message' => 'The information has been updated'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Oops something went wrong, Please try again'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        if ($error = $this->authorize('subject-delete')) {
            return $error;
        }

        try {
            $subject->delete();

            return response()->json(['message' => 'The information has been deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Oops something went wrong, Please try again'], 500);
        }
    }
}
