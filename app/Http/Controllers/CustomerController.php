<?php

namespace App\Http\Controllers;

use App\Category;
use App\Event;
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
}
