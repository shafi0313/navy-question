<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Rank;
use App\Models\Subject;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function select2(Request $request)
    {
        if ($request->ajax()) {
            switch ($request->type) {
                case 'getExam':
                    $response = Exam::select('id', 'name')
                        ->where('name', 'like', "%{$request->q}%")
                        ->orderBy('name')
                        ->limit(10)
                        ->get()->map(function ($data) {
                            return [
                                'id' => $data->id,
                                'text' => $data->name,
                            ];
                        })->toArray();
                    break;
                case 'getSubjectByExam':
                    $response = Subject::select('id', 'name')
                        ->where('name', 'like', "%{$request->q}%")
                        ->whereExamId($request->exam_id)
                        ->orderBy('name')
                        ->limit(10)
                        ->get()->map(function ($data) {
                            return [
                                'id' => $data->id,
                                'text' => $data->name,
                            ];
                        })->toArray();
                    break;
                case 'getRank':
                    $response = Rank::select('id', 'name')
                        ->where('name', 'like', "%{$request->q}%")
                        ->orderBy('name')
                        ->limit(10)
                        ->get()->map(function ($data) {
                            return [
                                'id' => $data->id,
                                'text' => $data->name,
                            ];
                        })->toArray();
                    break;
                // case 'getChapterBySubject':
                //     $response = Chapter::select('id', 'name')
                //         ->where('name', 'like', "%{$request->q}%")
                //         ->whereSubjectId($request->subject_id)
                //         ->orderBy('name')
                //         ->limit(10)
                //         ->get()->map(function ($data) {
                //             return [
                //                 'id' => $data->id,
                //                 'text' => $data->name,
                //             ];
                //         })->toArray();
                //     break;
                    // case 'getProduct':
                    //     $query = Product::with(['generic' => function ($q) {
                    //         $q->select('id', 'name');
                    //     }])->select('id', 'name', 'generic_id', 'company')
                    //         ->where(venQuery())
                    //         ->whereIsActive(1)
                    //         ->where('name', 'like', "%{$request->q}%")
                    //         ->orderBy('name')
                    //         ->limit(10);

                    //     if (! empty($request->data['company'])) {
                    //         $query->whereCompany($request->data['company']);
                    //     }

                    //     $response = $query->get()
                    //         ->map(function ($data) {
                    //             return [
                    //                 'id' => $data->id,
                    //                 'text' => $data->name,
                    //             ];
                    //         })->toArray();
                    //     break;
                default:
                    $response = [];
                    break;
            }
            $name = preg_split('/(?=[A-Z])/', str_replace('get', '', $request->type), -1, PREG_SPLIT_NO_EMPTY);
            $name = implode(' ', $name);

            // array_unshift($response, ['id' => ' ', 'text' => 'All '.$name]);
            return $response;
        }

        return abort(404);
    }
}
