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

        return Pdf::view('admin.pdfTamplates.service_report', compact('companies', 'serviceEvent'))
            ->format('a4')
            ->name('service_report.pdf');

    }
}
