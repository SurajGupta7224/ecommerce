<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Categories;

class ProductController extends Controller
{
    public function index()
{
    $products = Product::all();
    $categories_name = Categories::all();
    return view('index', compact('products','categories_name'));
    
}
public function search(Request $request)
{
    $query = $request->input('query');

    // Search products by title or other relevant fields
    $products = Product::where('title_name', 'LIKE', "%$query%")->get();

    // Return the search results as JSON for the frontend to handle
    return response()->json($products);
}

public function store(Request $request)
{
    // Validate the incoming request
    $request->validate([
        'productName' => 'required|string|max:255',
        'productCategory' => 'required|string|max:255',
        'productPrice' => 'required|numeric|min:0',
        'productImage' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Image validation
    ]);

    try {
        // Store the image in the 'public/product_img' folder
        $imagePath = $request->file('productImage')->store('product_img', 'public');

        // Create a new product instance
        $product = new Product();
        $product->title_name = $request->productName;     // Use productName from request
        $product->price = $request->productPrice;         // Use productPrice from request
        $product->categories = $request->productCategory;  // Use productCategory from request
        $product->image = $imagePath;                      // Set the image path
        $product->save();                                   // Save the product to the database

        // Redirect back to the 'add' route with a success message
        return redirect()->back()->with('success', 'Product added successfully!');
    } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error('Product addition failed: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to add product: ' . $e->getMessage());
    }
}




}
