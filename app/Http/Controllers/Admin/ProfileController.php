<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::whereId(Auth::user()->id)->first();

        return view('admin.my_profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'designation' => 'nullable|max:80',
            'd_o_b' => 'required|date',
            'address' => 'required|max:255',
            'password' => ['nullable', 'confirmed', Password::min(6)
                ->letters()
                                                            // ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised()],
        ]);
        $password = $request->password;
        $user = [
            'name' => $request->name,
            'designation' => $request->designation,
            'd_o_b' => $request->d_o_b,
            'address' => $request->address,
        ];
        if (! empty($password)) {
            $user['password'] = $password;
        }

        try {
            User::whereId(Auth::user()->id)->update($user);
            toast('success', 'Success');

            return back();
        } catch (\Exception $ex) {
            // return $ex->getMessage();
            toast('error', 'Error');
            // return back();
        }
    }
}
