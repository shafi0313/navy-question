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
                case 'getSubjectByRank':
                    $response = Subject::select('id', 'name')
                        ->where('name', 'like', "%{$request->q}%")
                        ->whereRankId($request->rank_id)
                        ->orderBy('name')
                        ->limit(10)
                        ->get()->map(function ($data) {
                            return [
                                'id' => $data->id,
                                'text' => $data->name,
                            ];
                        })->toArray();
                    break;
                case 'getSubject':
                    $response = Subject::select('id', 'rank_id', 'name')
                        ->with('rank:id,name')
                        ->where('name', 'like', "%{$request->q}%")
                        ->orderBy('name')
                        ->limit(10)
                        ->get()->map(function ($data) {
                            return [
                                'id' => $data->id,
                                'text' => $data->name.' ('.$data->exam->name.')',
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
                default:
                    $response = [];
                    break;
            }
            $name = preg_split('/(?=[A-Z])/', str_replace('get', '', $request->type), -1, PREG_SPLIT_NO_EMPTY);
            $name = implode(' ', $name);

            return $response;
        }

        return abort(404);
    }
}
