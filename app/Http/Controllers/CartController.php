<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        try {
            if (!Auth::check()) {
                return redirect()->route('login')->with('error', 'Vui lòng đăng nhập');
            }

            $user = Auth::user();
            
            $cartItems = Cart::where('user_id', $user->id)
                ->with('course')
                ->get();
            
            $total = 0;
            foreach ($cartItems as $item) {
                if ($item->course) {
                    $total += $item->unit_price * $item->quantity;
                }
            }
            
            return view('cart.index', [
                'cartItems' => $cartItems,
                'total' => $total,
                'user' => $user
            ]);
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            if (!Auth::check()) {
                return redirect()->route('login');
            }

            $request->validate([
                'course_id' => 'required|exists:courses,course_id'
            ]);

            $user = Auth::user();
            $course = Course::where('course_id', $request->course_id)->firstOrFail();

            $existingCart = Cart::where('user_id', $user->id)
                ->where('course_id', $course->course_id)
                ->first();

            if ($existingCart) {
                $existingCart->increment('quantity');
            } else {
                Cart::create([
                    'user_id' => $user->id,
                    'course_id' => $course->course_id,
                    'unit_price' => $course->price,
                    'quantity' => 1,
                    'added_at' => now(),
                ]);
            }

            return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            if (!Auth::check()) {
                return redirect()->route('login');
            }

            $user = Auth::user();
            $cartItem = Cart::where('user_id', $user->id)
                ->where('id', $id)
                ->first();

            if ($cartItem) {
                $cartItem->delete();
            }

            return redirect()->route('cart.index')->with('success', 'Đã xóa khỏi giỏ hàng');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    // THÊM METHOD NÀY
    public function clear(Request $request)
    {
        try {
            if (!Auth::check()) {
                return redirect()->route('login');
            }

            $user = Auth::user();
            Cart::where('user_id', $user->id)->delete();

            return redirect()->route('cart.index')->with('success', 'Đã xóa toàn bộ giỏ hàng');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }
}