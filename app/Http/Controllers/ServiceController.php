<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index()
    {   
        $dataCategories = Category::latest()->get();
        return view('content.client.service', [
            'categories' => $dataCategories,
        ]);
    }

    public function bookingPage(Category $category)
    {
        return view('content.client.booking', [
            'category' => $category,
        ]);
    }

    public function booking(Request $request)
    {   
        $price = Category::where('id', $request['category_id'])->first();
        $request['total_price'] = $price->price * $request['number_of_people'];
        $request['status'] = 'Ordered';

        $validasi = $request->validate([
            'user_id' => 'required',
            'category_id' => 'required',
            'number_of_people' => 'required',
            'total_price' => 'required',
            'date' => 'required',
            'time' => 'required',
            'status' => 'required',
        ]);

        Booking::create($validasi);

        return redirect('/myorder')->with('success', 'You have successfully placed an order');
    }

    public function myorder()
    {
        $myorder = Booking::latest()->where('user_id', Auth::user()->id)->get();
        return view('content.client.myorder', [
            'bookings' => $myorder,
        ]);
    }
    
}
