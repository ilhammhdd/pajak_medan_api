<?php

namespace App\Http\Controllers;

use App\Category;
use App\Event;
use App\Good;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class CustomerController extends BaseController
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

    public function getEvents()
    {
        $eventsAll = Event::all();
        $events = [];

        foreach ($eventsAll as $event) {
            $events[] = [
                "id" => $event->id,
                "file_path" => $event->file()->pluck('file_path')->first(),
                "name" => $event->name
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Successfully get all events',
            'events' => $events
        ]);
    }

    public function getGoods(Request $request)
    {
        $goods = Good::where('category_id', $request->json("data")["category_id"])->get();
        $goodsJsonArray = [];

        foreach ($goods as $good) {
            $goodsJsonArray[] = [
                "id" => $good->id,
                "file_path" => $good->file()->pluck("file_path")->first(),
                "name" => $good->name,
                "price" => $good->price,
                "description" => $good->desciption,
                "available" => $good->available,
                "unit" => $good->unit
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Successfully get all goods of the given category',
            'goods' => $goodsJsonArray
        ]);
    }
}
