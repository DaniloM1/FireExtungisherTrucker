<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    // Vraća sve gradove
    public function index()
    {
        $cities = City::all();
        return response()->json($cities);
    }

    // Pretraga grada: prima parametar 'query'
    public function search(Request $request)
    {
        $searchInput = $request->input('query'); // npr. "neka kuca Ćuprija"
        $tokens = array_filter(explode(' ', $searchInput)); // razdeli unos na reči

        // Pretraži gradove: ako bilo koji token delimično poklapa ime grada
        $cityQuery = City::where(function ($query) use ($tokens) {
            foreach ($tokens as $token) {
                $query->orWhere('name', 'LIKE', "%{$token}%");
            }
        });

        $cities = $cityQuery->get(); // Izvrši upit i uzmi rezultate

        if ($cities->isNotEmpty()) {
            return response()->json(['cities' => $cities]);
        } else {
            return response()->json(['message' => 'City not found'], 404);
        }
    }

}
