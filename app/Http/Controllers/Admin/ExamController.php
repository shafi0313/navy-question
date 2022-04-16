<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exam;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ExamController extends Controller
{
    public function index()
    {
        if ($error = $this->sendPermissionError('index')) {
            return $error;
        }
        $exams = Exam::all();
        return view('admin.exam.index', compact('exams'));
    }

    public function create()
    {
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }
        $subjects = Subject::all();
        return view('admin.exam.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        if ($error = $this->sendPermissionError('create')) {
            return $error;
        }
        $data = $this->validate($request, [
            'subject_id' => 'required|integer',
            'name' => 'required|max:100',
            'code' => 'required|max:60',
            'date_time' => 'required|after:starting_hour',
            'time' => 'required',
            'total_ques' => 'required|integer',
            'total_mark' => 'required|integer',
            // 'mark_per_right_ans' => 'required|integer',
            // 'mark_per_wrong_ans' => 'required|integer',
        ]);
        $data['user_id'] = auth()->user()->id;
        $data['status'] = 'Pending';

        DB::beginTransaction();

        try{
            Exam::create($data);
            DB::commit();
            toast('success','Success');
            return redirect()->route('admin.exam.index');
        }catch(\Exception $ex){
            return $ex->getMessage();
            DB::rollBack();
            toast('error','Error');
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if ($error = $this->sendPermissionError('edit')) {
            return $error;
        }
        $user = User::with('accessPermission')->find($id);
        return view('admin.exam.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        if ($error = $this->sendPermissionError('edit')) {
            return $error;
        }
        $this->validate($request, [
            'name' => 'required|max:100',
            // 'email' => 'required|email|unique:users,email',
            'address' => 'required',
            'd_o_b' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'password' => ['nullable', 'confirmed', Password::min(6)
                                                            ->letters()
                                                            // ->mixedCase()
                                                            ->numbers()
                                                            ->symbols()
                                                            ->uncompromised()],
        ]);

        DB::beginTransaction();

        $data = [
            'name' => $request->name,
            'designation' => $request->designation,
            'd_o_b' => $request->d_o_b,
            'phone' => $request->phone,
            'address' => $request->address,
        ];

        if($request->hasFile('image')){
            $files = User::where('id', $id)->first();
            $path =  public_path('uploads/images/users/'.$files->image);
            file_exists($path) ? unlink($path) : false;

            $path = public_path().'/uploads/images/users/';
            !file_exists($path) ?? File::makeDirectory($path, 0777, true, true);

            $image = $request->file('image');
            $image_name = "admin_user_".rand(0,1000).'.'.$image->getClientOriginalExtension();
            $request->image->move('uploads/images/users/',$image_name);

            $data['image'] = $image_name;
        }

        if($request->permission==0){
            $data['permission'] = 0;
        }else{
            $data['permission'] = 1;
        }

        if(isset($request->password)){
            $data['password'] = bcrypt($request->input('password'));
        }

        try{
            User::find($id)->update($data);
            if($request->permission){
                $permission = [
                    'role_id' =>  $request->permission,
                    'model_type' => "App\Models\User",
                    'model_id' =>  $id,
                ];
                ModelHasRole::where('model_id',$id)->update($permission) || ModelHasRole::create($permission);
            }

            DB::commit();
            toast('success','Success');
            return redirect()->route('admin.adminUser.index');
        }catch(\Exception $ex){
            return $ex->getMessage();
            DB::rollBack();
            toast('error','Error');
            return redirect()->back();
        }
    }


    public function destroy($id)
    {
        if ($error = $this->sendPermissionError('delete')) {
            return $error;
        }
        $user = User::find($id);
        $path =  public_path('uploads/images/users/'.$user->image);
        if(file_exists($path) && !is_null($user->image)){
            unlink($path);
            $user->delete();
            toast('Successfully Deleted','success');
            return redirect()->back();
        }else{
            $user->delete();
            toast('Successfully Deleted','success');
            return redirect()->back();
        }
    }
}
