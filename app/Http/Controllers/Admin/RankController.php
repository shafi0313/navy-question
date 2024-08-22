<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Validated;
use App\Http\Requests\StoreRankRequest;
use App\Http\Requests\UpdateRankRequest;
use Yajra\DataTables\Facades\DataTables;

class RankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($error = $this->authorize('rank-manage')) {
            return $error;
        }
        if ($request->ajax()) {
            $exams = Rank::query();

            return DataTables::of($exams)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if (userCan('rank-edit')) {
                        $btn .= view('button', ['type' => 'ajax-edit', 'route' => route('admin.ranks.edit', $row->id), 'row' => $row]);
                    }
                    if (userCan('s-delete')) {
                        $btn .= view('button', ['type' => 'ajax-delete', 'route' => route('admin.ranks.destroy', $row->id), 'row' => $row, 'src' => 'dt']);
                    }
                    return $btn;
                })
                ->rawColumns(['action', 'created_at'])
                ->make(true);
        }

        return view('admin.rank.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRankRequest $request)
    {
        $data = $request->Validated();
        try {
            Rank::create($data);
            return response()->json(['message' => 'Data Successfully Inserted'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => __('app.oops')], 500);
            // return response()->json(['message'=>$e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Rank $rank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rank $rank)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRankRequest $request, Rank $rank)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rank $rank)
    {
        if ($error = $this->authorize('rank-delete')) {
            return $error;
        }
        try {
            $rank->delete();

            return response()->json(['message' => 'ClassRoom Deleted Successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => __('app.oops')], 500);
            // return response()->json(['message'=>$e->getMessage()], 500);
        }
    }
}
