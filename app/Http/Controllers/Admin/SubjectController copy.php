<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Exam;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    public function index()
    {
        $exams = Exam::all();
        $subjects = Subject::with('chapters', 'exam')->get();

        return view('admin.subjects.index', compact('subjects', 'exams'));
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'exam_id' => 'required|numeric',
            'name' => 'required|string|max:191',
            'trade' => 'required|string|max:191',
        ]);

        DB::beginTransaction();

        try {
            Subject::create($data);
            DB::commit();
            toast('Success!', 'success');
        } catch (\Exception $ex) {
            // // return $ex->getMessage();
            DB::rollBack();
            toast('error', 'Error');
        }

        return back();
    }

    public function update(Request $request, $id)
    {
        $data = $this->validate($request, [
            'exam_id' => 'required|numeric',
            'name' => 'required|string|max:191',
            'trade' => 'required|string|max:191',
        ]);

        DB::beginTransaction();

        try {
            Subject::find($id)->update($data);
            DB::commit();
            toast('success', 'Success');
        } catch (\Exception $ex) {
            // return $ex->getMessage();
            DB::rollBack();
            toast('error', 'Error');
        }

        return back();
    }

    public function destroy($id)
    {
        try {
            Subject::find($id)->delete();
            Chapter::whereSubject_id($id)->delete();
            toast('Success!', 'success');
        } catch (\Exception $ex) {
            toast('Failed', 'error');
        }

        return back();
    }
}
