<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;

class CategoryController extends Controller
{
    public function show()
{
    $categories_name = Categories::all();
    return view('add', compact('categories_name'));
}

}
