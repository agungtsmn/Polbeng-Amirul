<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MainController extends Controller
{
  public function home()
  {
    return view('content.client.home');
  }

  public function loginPage()
  {
    return view('content.client.login');
  }

  public function login(Request $request)
  {
    $validasi = $request->validate([
      'username' => 'required',
      'password' => 'required',
    ]);

    
    if (Auth::attempt($validasi)) {
      $request->session()->regenerate();

      $getRole = User::where('username', $request->username)->first();
      // dd($getRole);
      if ($getRole->role == 'Admin') {
        return redirect()->intended('/dashboard');
      } else {
        return redirect()->intended('/service');
      }

    } else {
      return back()->with('error', 'Username atau password salah!');
    }
  }

  public function registerPage()
  {
    return view('content.client.register');
  }

  public function register(Request $request)
  {   
    $request['role'] = 'Penyewa';
    $validasi = $request->validate([
      'name' => 'required|alpha',
      'username' => 'required|unique:users',
      'password' => 'required|min:8',
      'phone_number' => 'required|in:62',
      'role' => 'required',
    ]);

    $validasi['password'] = Hash::make($validasi['password']);
    User::create($validasi);
    return redirect('/login/page');
  }

  public function logout(Request $request)
  {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
  }

  public function dashboard()
  { 
    $userCount = User::count();
    $categoryCount = Category::count();
    $bookingCount = Booking::count();
    return view('content.admin.dashboard', [
      'userCount' => $userCount,
      'categoryCount' => $categoryCount,
      'bookingCount' => $bookingCount,
    ]);
  }
}
