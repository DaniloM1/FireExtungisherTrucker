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
        // Pretpostavimo da korisnikov unos dolazi kao parametar "query"
        $searchInput = $request->input('query'); // npr. "neka kuca Ćuprija"

        // Razdvoji unos na reči i ukloni eventualne praznine
        $tokens = array_filter(explode(' ', $searchInput));

        // Primer 1: Pretraga gde tražimo grad ako bilo koji token sadrži ime grada
        $city = City::where(function ($query) use ($tokens) {
            foreach ($tokens as $token) {
                // Ovo koristi LIKE pretragu – token može biti deo imena grada
                $query->orWhere('name', 'LIKE', "%{$token}%");
            }
        })->first();

        // Primer 2 (alternativa): Ako želiš tačno poklapanje, možeš pretraživati da li neki od tokena
        // tačno odgovara imenu grada
        /*
        $city = City::whereIn('name', array_map('trim', $tokens))->first();
        */

        if ($city) {
            return response()->json(['city' => $city]);
        } else {
            return response()->json(['message' => 'City not found'], 404);
        }
    }
}

