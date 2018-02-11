<?php

namespace App\Http\Controllers;

use App\Category;
use Laravel\Lumen\Routing\Controller as BaseController;

class CustomerController extends BaseController
{
    public function getCategories()
    {
        $categories = Category::with('file')->get();
        $jsonCategories = json_encode($categories);

        return response()->json([
            'success' => true,
            'message' => 'Successfully get all categories',
            'categories' => $jsonCategories
        ]);
    }
}
