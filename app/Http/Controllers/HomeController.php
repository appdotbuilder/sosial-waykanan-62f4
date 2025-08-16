<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\AssistanceType;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page with statistics.
     */
    public function index(Request $request)
    {
        $stats = [
            'total_applications' => Application::count(),
            'pending_applications' => Application::whereIn('status', ['submitted', 'under_review'])->count(),
            'approved_applications' => Application::where('status', 'approved')->count(),
            'total_citizens' => User::where('role', 'citizen')->count(),
            'assistance_types' => AssistanceType::active()->count(),
        ];

        $recentApplications = [];
        if (Application::count() > 0) {
            $recentApplications = Application::with(['user', 'assistanceType'])
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($application) {
                    return [
                        'id' => $application->id,
                        'application_number' => $application->application_number,
                        'applicant_name' => $application->applicant_name,
                        'assistance_type' => $application->assistanceType->name,
                        'status' => $application->status,
                        'status_label' => $application->getStatusLabelAttribute(),
                        'created_at' => $application->created_at->format('d M Y'),
                    ];
                });
        }

        return view('welcome', [
            'stats' => $stats,
            'recentApplications' => $recentApplications,
        ]);
    }
}