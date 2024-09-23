<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($error = $this->authorize('user-manage')) {
            return $error;
        }

        if ($request->ajax()) {
            $users = User::with([
                'createdBy:id,name',
                'updatedBy:id,name',
                'roles:id,name',
            ])->orderBy('name');

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    return '<img src="'.imagePath('users', $row->image).'" width="70px">';
                })
                ->addColumn('roleName', function ($row) {
                    $roleName = '';
                    foreach ($row->roles as $role) {
                        $roleName .= '<span class="badge badge-primary">'.$role->name.'</span>';
                    }

                    return $roleName;
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if (userCan('user-edit')) {
                        $btn .= view('button', ['type' => 'ajax-edit', 'route' => route('admin.users.edit', $row->id), 'row' => $row]);
                    }
                    if (userCan('user-delete')) {
                        $btn .= view('button', ['type' => 'ajax-delete', 'route' => route('admin.users.destroy', $row->id), 'row' => $row, 'src' => 'dt']);
                    }

                    return $btn;
                })
                ->rawColumns(['roleName', 'action', 'image'])
                ->make(true);
        }
        $roles = Role::all();

        return view('admin.user.index', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        if ($error = $this->authorize('user-add')) {
            return $error;
        }
        $data = $request->validated();
        $data['permission'] = '1';
        $data['password'] = bcrypt($request->password);
        $data['created_by'] = user()->id;
        if ($request->hasFile('image')) {
            $data['image'] = imgProcessAndStore($request->image, 'users', [200, 200]);
        }

        try {
            $user = User::create($data);
            $user->assignRole($request->role);

            return response()->json(['message' => 'The information has been inserted'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Oops something went wrong, Please try again.'], 500);
        }
    }

    public function edit(Request $request, User $user)
    {
        if ($error = $this->authorize('user-edit')) {
            return $error;
        }
        if ($request->ajax()) {
            $roles = Role::all();
            $modal = view('admin.user.edit')->with(['user' => $user, 'roles' => $roles])->render();

            return response()->json(['modal' => $modal], 200);
        }

        return abort(500);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        if ($error = $this->authorize('user-add')) {
            return $error;
        }
        $data = $request->validated();
        $data['permission'] = '1';
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
        if ($error = $this->authorize('user-delete')) {
            return $error;
        }
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
