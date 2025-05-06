<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;
use App\Models\ServiceEvent;
use App\Models\Company;

class PDFController extends Controller
{
    public function generateServiceReport($serviceEventId)
    {
        // Eager-load locations sa devices i serviceEvents
        $serviceEvent = ServiceEvent::with([
            'locations' => function($q) {
                $q->with([
                    'devices'       => fn($q2) => $q2->where('status', 'active'),
                    'serviceEvents' // <-- dodajemo ovde
                ]);
            }
        ])->findOrFail($serviceEventId);

        $locationIds = $serviceEvent->locations->pluck('id')->toArray();

        $companies = Company::whereHas('locations', fn($q) => $q->whereIn('id', $locationIds))
            ->with([
                'locations' => function($q) use ($locationIds) {
                    $q->whereIn('id', $locationIds)
                        ->with([
                            'devices'       => fn($q2) => $q2->where('status', 'active'),
                            'serviceEvents' // <-- i ovde
                        ]);
                }
            ])->get();

        return Pdf::view('admin.pdfTamplates.service_report', compact('companies'))
            ->format('a4')
            ->name('service_report.pdf');
    }
}
