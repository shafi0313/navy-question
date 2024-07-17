<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class GlobalController extends Controller
{
    public function getSubject(Request $request)
    {
        $inputs = Subject::whereExam_id($request->exam_id)->get();
        $subjects = view('admin.global.get_subject', ['inputs' => $inputs])->render();

        return response()->json(['status' => 'success', 'html' => $subjects, 'subjects']);
    }
}
