<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function searchCity(Request $request)
    {
        $searchInput = $request->input('query');
        $tokens = array_filter(explode(' ', $searchInput));

        $city = City::where(function ($query) use ($tokens) {
            foreach ($tokens as $token) {
                $query->orWhere('name', 'LIKE', "%{$token}%");
            }
        })->first();
        if ($city) {
            return response()->json(['city' => $city]);
        } else {
            return response()->json(['message' => 'City not found'], 404);
        }
    }
}

