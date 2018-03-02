<?php
/**
 * Created by PhpStorm.
 * User: milha
 * Date: 2/27/2018
 * Time: 4:21 PM
 */

namespace App\Http\Controllers;


use App\Category;

class CategoryController extends Controller
{
    public function getCategories()
    {
        $categories = Category::all();
        $categoriesInArray = [];

        foreach ($categories as $category) {
            $categoriesInArray[] = [
                "id" => $category->id,
                "file_path" => $category->file()->pluck('file_path')->first(),
                "name" => $category->name,
                "description" => $category->description
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Successfully get all categories',
            'categories' => $categoriesInArray
        ]);
    }
}