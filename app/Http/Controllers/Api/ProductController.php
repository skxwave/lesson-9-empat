<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function categoryList() {
        $category = Category::all();

        return response()->json($category);
    }

    public function categoryShow(Request $request) {
        $category = Category::find($request->id);

        return response()->json($category->products);
    }
}
