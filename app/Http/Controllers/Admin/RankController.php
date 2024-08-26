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
        if ($error = $this->authorize('rank-edit')) {
            return $error;
        }

        if ($request->ajax()) {
            $modal = view('admin.product.rank.edit')->with(['rank' => $rank])->render();

            return response()->json(['modal' => $modal], 200);
        }

        return abort(500);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRankRequest $request, Rank $rank)
    {
        if ($error = $this->authorize('brand-add')) {
            return $error;
        }

        $data = $request->validated();
        $image = $brand->logo;
        if ($request->hasFile('logo')) {
            $data['logo'] = imgWebpUpdate($request->logo, 'brand', [400, 400], $image);
        }
        try {
            $brand->update($data);

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
        if ($error = $this->authorize('rank-delete')) {
            return $error;
        }
        try {
            $rank->delete();

            return response()->json(['message' => 'The information has been deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Oops something went wrong, Please try again.'], 500);
        }
    }
}
