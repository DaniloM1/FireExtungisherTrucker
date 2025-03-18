<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf; // Uverite se da je paket ispravno instaliran i konfigurisan
use App\Models\ServiceEvent;
use App\Models\Company;

class PDFController extends Controller
{
    public function generateServiceReport($serviceEventId)
    {
        // Preuzmite servisni događaj sa njegovim povezanim lokacijama i uređajima
        $serviceEvent = ServiceEvent::with([
            'locations' => function ($query) {
                $query->with(['devices' => function ($query) {
                    $query->where('status', 'active');
                }]);
            }
        ])->findOrFail($serviceEventId);

        // Izvučemo ID-jeve lokacija iz servisnog događaja
        $locationIds = $serviceEvent->locations->pluck('id')->toArray();

        // Učitajte kompanije čije lokacije su deo servisnog događaja.
        // Relacija "locations" se filtrira da sadrži samo one koje su u nizu $locationIds,
        // a unutar njih se eager load-uju uređaji (koji su već filtrirani da budu aktivni).
        $companies = Company::whereHas('locations', function ($query) use ($locationIds) {
            $query->whereIn('id', $locationIds);
        })
            ->with(['locations' => function ($query) use ($locationIds) {
                $query->whereIn('id', $locationIds)
                    ->with(['devices' => function ($query) {
                        $query->where('status', 'active');
                    }]);
            }])
            ->get();


        // Generišemo PDF koristeći Blade view i prosleđene podatke
        $pdf = Pdf::view('admin.pdfTamplates.service_report', compact('companies'))
            ->format('a4'); // primer dodatne opcije formatiranja

        return view('admin.pdfTamplates.service_report', compact('companies'));

        // Vraćamo PDF za preuzimanje ili prikaz u browseru
//        return $pdf->download('service_report.pdf');
        // alternativno: return $pdf->stream('service_report.pdf');
    }
}

