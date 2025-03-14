<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::all();
        return response()->json($cities);
    }

    public function search(Request $request)
    {
        $searchInput = $request->input('query');
        $tokens = array_filter(explode(' ', $searchInput));

        $cityQuery = City::where(function ($query) use ($tokens) {
            foreach ($tokens as $token) {
                $query->orWhere('name', 'LIKE', "%{$token}%");
            }
        });

        $cities = $cityQuery->get();

        if ($cities->isNotEmpty()) {
            return response()->json(['cities' => $cities]);
        } else {
            return response()->json(['message' => 'City not found'], 404);
        }
    }

}
