<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{

public function update(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email',
        'old_password' => 'required',
        'password' => 'required|confirmed',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!Hash::check($request->old_password, $user->password)) {
        return back()->withErrors([
            'old_password' => 'Old password is incorrect',
        ]);
    }

    $user->password = Hash::make($request->password);
    $user->save();

    return redirect('/login')->with('toastMessage', 'Đổi mật khẩu thành công.')
                ->with('toastRedirect', '/login');
}
}

