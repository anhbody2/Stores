<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Console\Input\Input;

use function Laravel\Prompts\error;
use function PHPUnit\Framework\isNull;

class UserController extends Controller
{
    public function Login(Request $request)
    {
        $login = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];
        if (Auth::attempt($login)) {
            $user = Auth::user();
            Session::put('user', $user);

            return redirect('/')->with('toastMessage', 'Đăng nhập thành công.')
                ->with('toastRedirect', '/');
        } else {
            return redirect('/login')->with('toastMessage', 'Đăng nhập thất bại.')
                ->with('toastRedirect', '/login');
        }
    }
    public function GetLogin()
    {
        return view('users_page.login');
    }

    public function GetLogout()
    {
        Session::forget('user');
        Session::forget('cart');
        return redirect('/');
    }

    public function Logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Session::forget('cart');
        Session::forget('user');
        return redirect('/')->with('success', 'Đăng xuất thành công.');
    }

    public function GetUser()
    {
        return view('users_page.register');
    }

    public function Register(Request $request)
    {
        try {
            $input = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'c_password' => 'required|same:password'
            ]);

            $input['password'] = bcrypt($input['password']);

            User::create($input);

           return redirect('/login')->with('toastMessage', 'Đăng ký thành công.')
                ->with('toastRedirect', '/login');
        } catch (\Exception $e) {
            echo "<script>console.log('Register failed: " . $e->getMessage() . "');</script>";
              return redirect('/register')->with('toastMessage', 'Register failed')
                ->with('toastRedirect', '/register');
            
        }
    }
 
}
