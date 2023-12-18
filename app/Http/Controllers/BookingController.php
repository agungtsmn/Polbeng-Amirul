<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataBooking = Booking::latest()->get();
        $dataUser = User::all();
        $dataCategory = Category::all();
        return view('content.admin.booking', [
            'bookings' => $dataBooking,
            'users' => $dataUser,
            'categories' => $dataCategory,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBookingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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

        return redirect('/manage/booking')->with('success', 'Data pemesanan berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    // public function show(Booking $booking)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    // public function edit(Booking $booking)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        $price = Category::where('id', $request['category_id'])->first();
        $request['total_price'] = $price->price * $request['number_of_people'];

        $validasi = $request->validate([
            'user_id' => 'required',
            'category_id' => 'required',
            'number_of_people' => 'required',
            'total_price' => 'required',
            'date' => 'required',
            'time' => 'required',
            'status' => 'required',
        ]);

        $booking->update($validasi);

        return redirect('/manage/booking')->with('update', 'Data pemesanan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect('/manage/booking')->with('delete', 'Data pemesanan berhasil dihapus!');
    }
}
