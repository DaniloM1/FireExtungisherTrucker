<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ServiceEvent;
use App\Models\Company;

class PDFController extends Controller
{
    public function generateServiceReport($serviceEventId)
    {
        $serviceEvent = ServiceEvent::with([
            'locations' => function($q) {
                $q->with([
                    'devices'       => fn($q2) => $q2->whereIn('status', ['active', 'needs_service']),
                    'serviceEvents'
                ]);
            }
        ])->findOrFail($serviceEventId);

        $locationIds = $serviceEvent->locations->pluck('id')->toArray();

        $companies = Company::whereHas('locations', fn($q) => $q->whereIn('id', $locationIds))
            ->with([
                'locations' => function($q) use ($locationIds) {
                    $q->whereIn('id', $locationIds)
                        ->with([
                            'devices'       => fn($q2) => $q2->whereIn('status', ['active', 'needs_service']),
                            'serviceEvents'
                        ]);
                }
            ])->get();

        // Kreiraj PDF iz Blade view-a
        $pdf = Pdf::loadView('admin.pdfTamplates.service_report', compact('companies', 'serviceEvent'))
                  ->setPaper('a4');
        return $pdf->download('service_report.pdf');
        // ili za direktan prikaz:
        // return $pdf->stream('service_report.pdf');
    }
}
