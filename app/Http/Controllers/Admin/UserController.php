<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::with([
                'createdBy:id,name',
                'updatedBy:id,name',
            ]);

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    return '<img src="' . imagePath('users', $row->image) . '" width="70px">';
                })
                ->addColumn('permission', function ($row) {
                    $permissions = config('var.permission');
                    return $permissions[$row->permission] ?? 'Unknown';
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    $btn .= view('button', ['type' => 'ajax-edit', 'route' => route('admin.users.edit', $row->id), 'row' => $row]);
                    $btn .= view('button', ['type' => 'ajax-delete', 'route' => route('admin.users.destroy', $row->id), 'row' => $row, 'src' => 'dt']);
                    return $btn;
                })
                ->rawColumns(['permission', 'action', 'image'])
                ->make(true);
        }

        return view('admin.user.index');
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($request->password);
        $data['created_by'] = user()->id;
        if ($request->hasFile('image')) {
            $data['image'] = imgProcessAndStore($request->image, 'users', [200, 200]);
        }

        try {
            DB::beginTransaction();
            User::create($data);
            DB::commit();
            return response()->json(['message' => 'The information has been inserted'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Oops something went wrong, Please try again.'], 500);
        }
    }

    public function edit(Request $request, User $user)
    {
        if ($request->ajax()) {
            $modal = view('admin.user.edit')->with(['user' => $user])->render();

            return response()->json(['modal' => $modal], 200);
        }

        return abort(500);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        
        $date['updated_by'] = user()->id;
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $existingImage = $user->image;
        if ($request->hasFile('image')) {
            $data['image'] = imgProcessAndStore($request->image, 'users', [200, 200], $existingImage);
        }

        try {
            $user->update($data);
            if ($request->has('role')) {
                $user->syncRoles($data['role']);
            }

            return response()->json(['message' => 'The information has been updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);

            return response()->json(['message' => 'Oops, something went wrong. Please try again.'], 500);
        }
    }

    public function destroy(User $user)
    {
        try {
            imgUnlink('users', $user->image);
            $user->delete();

            return response()->json(['message' => 'Data Successfully Deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Oops something went wrong, Please try again.'], 500);
            // return response()->json(['message'=>$e->getMessage()], 500);
        }
    }
}
