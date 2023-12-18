<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataCategory = Category::latest()->get();
        return view('content.admin.category', [
            'data' => $dataCategory,
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validasi = $request->validate([
            'type' => 'required',
            'price' => 'required',
            'category_img' => 'required|mimes:jpeg,jpg,png|max:5120',
        ]);

        if ($request->file('category_img')) {
            $validasi['category_img'] = $request->file('category_img')->store('berkas_category_img');
        }

        Category::create($validasi);

        return redirect('/manage/category')->with('success', 'Data kategori berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    // public function show(Category $category)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    // public function edit(Category $category)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validasi = $request->validate([
            'type' => 'required',
            'price' => 'required',
            'category_img' => 'nullable|mimes:jpeg,jpg,png|max:5120',
        ]);

        if ($request->file('category_img')) {
            Storage::delete($category->category_img);
            $validasi['category_img'] = $request->file('category_img')->store('berkas_category_img');
        }

        $category->update($validasi);

        return redirect('/manage/category')->with('udpate', 'Data kategori berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if ($category->category_img) {
            Storage::delete($category->category_img);
        }
        $category->delete();
        return redirect('/manage/category')->with('delete', 'Data kategori berhasil dihapus!');
    }
}
