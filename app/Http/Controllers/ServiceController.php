<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {   
        $dataCategories = Category::latest()->get();
        return view('content.client.service', [
            'categories' => $dataCategories,
        ]);
    }
}
