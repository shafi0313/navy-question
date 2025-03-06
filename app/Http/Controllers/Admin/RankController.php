<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRankRequest;
use App\Http\Requests\UpdateRankRequest;
use App\Models\Rank;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $exams = Rank::with([
                'createdBy:id,name',
                'updatedBy:id,name',
            ]);

            return DataTables::of($exams)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '';
                    $btn .= view('button', ['type' => 'ajax-edit', 'route' => route('admin.ranks.edit', $row->id), 'row' => $row]);
                    $btn .= view('button', ['type' => 'ajax-delete', 'route' => route('admin.ranks.destroy', $row->id), 'row' => $row, 'src' => 'dt']);

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
        $data['created_by'] = user()->id;
        try {
            Rank::create($data);

            return response()->json(['message' => 'The information has been inserted'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Oops something went wrong, Please try again.'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Rank $rank)
    {
        if ($request->ajax()) {
            $modal = view('admin.rank.edit')->with(['rank' => $rank])->render();

            return response()->json(['modal' => $modal], 200);
        }

        return abort(500);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRankRequest $request, Rank $rank)
    {
        $data = $request->validated();
        $data['updated_by'] = user()->id;
        try {
            $rank->update($data);

            return response()->json(['message' => 'The information has been updated'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Oops something went wrong, Please try again'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rank $rank)
    {
        try {
            $rank->delete();

            return response()->json(['message' => 'The information has been deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Oops something went wrong, Please try again.'], 500);
        }
    }
}
