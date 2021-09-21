<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Station;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/admin/users');
    }

    public function edit(User $user)
    {
        $roles = DB::table('roles')->pluck('slug', 'id');
        $stations = Station::all();
        return view('users.edit', compact('user', 'roles', 'stations'));
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        return redirect('/admin/users');
    }

    public function destroy(User $user)
    {
        return redirect('/admin/users')->with('message', 'در حال حاضر امکان حذف وجود ندارد.')->with('type', 'danger');
    }

    public function resetPassword(User $user)
    {
        try {
            $user->update(['password' => Hash::make($user->mobile)]);

            return $this->success('رمز عبور با موفقیت به شماره موبایل کاربر تغییر یافت.');
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }

    public function changePassword($userId)
    {
        $user = User::find($userId);
        return view('users.changePassword', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        if (Hash::check($request->old_password, auth()->user()->password)) {
            if ($request->password == $request->password_confirmation) {
                auth()->user()->update(['password' => Hash::make($request->password)]);

                return redirect(route('users.changePassword', auth()->id()))->with('message', 'رمز عبور با موفقیت تغییر یافت.')->with('type', 'success');
            } else {
                return redirect(route('users.changePassword', auth()->id()))->with('message', 'رمز عبور جدید با تکرار آن همخوانی ندارد.')->with('type', 'danger');
            }
        } else {
            return redirect(route('users.changePassword', auth()->id()))->with('message', 'رمز عبور فعلی نادرست است.')->with('type', 'danger');
        }
    }

    public function assignUserStation(Request $request)
    {
        try {
            DB::table('user_stations')->insert([
                'user_id' => $request->user_id,
                'station_id' => $request->station_id,
            ]);
            return $this->success('success');
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }

    public function revokeUserStation(Request $request)
    {
        try {
            DB::table('user_stations')->where('user_id',$request->user_id)->where('station_id',$request->station_id)->delete();
            return $this->success('success');
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }
}
