<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /*
    get all recipes and filter by category
    */
    public function index()
    {
        try {

            return Category::all();

        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500,
            ], 500);

        }
    }
}
