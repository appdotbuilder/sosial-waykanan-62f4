<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\AssistanceType;
use App\Models\User;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        if ($user->role === 'citizen') {
            return $this->citizenDashboard($user);
        } else {
            return $this->officerDashboard($user);
        }
    }

    /**
     * Display citizen dashboard.
     */
    protected function citizenDashboard($user)
    {
        $stats = [
            'total_applications' => $user->applications()->count(),
            'pending_applications' => $user->applications()->whereIn('status', ['submitted', 'under_review', 'field_survey'])->count(),
            'approved_applications' => $user->applications()->where('status', 'approved')->count(),
            'completed_applications' => $user->applications()->where('status', 'completed')->count(),
        ];

        $recentApplications = $user->applications()
            ->with('assistanceType')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($application) {
                return [
                    'id' => $application->id,
                    'application_number' => $application->application_number,
                    'assistance_type' => $application->assistanceType->name,
                    'status' => $application->status,
                    'status_label' => $application->status_label,
                    'created_at' => $application->created_at->format('d M Y'),
                    'requested_amount' => $application->requested_amount,
                ];
            });

        return view('dashboard', [
            'userRole' => 'citizen',
            'stats' => $stats,
            'recentApplications' => $recentApplications,
        ]);
    }

    /**
     * Display officer/admin dashboard.
     */
    protected function officerDashboard($user)
    {
        $stats = [
            'total_applications' => Application::count(),
            'pending_review' => Application::where('status', 'submitted')->count(),
            'under_survey' => Application::where('status', 'field_survey')->count(),
            'approved_today' => Application::where('status', 'approved')->whereDate('approved_at', today())->count(),
            'total_citizens' => User::where('role', 'citizen')->count(),
            'active_assistance_types' => AssistanceType::active()->count(),
        ];

        $recentApplications = Application::with(['user', 'assistanceType'])
            ->whereIn('status', ['submitted', 'under_review'])
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($application) {
                return [
                    'id' => $application->id,
                    'application_number' => $application->application_number,
                    'applicant_name' => $application->applicant_name,
                    'assistance_type' => $application->assistanceType->name,
                    'status' => $application->status,
                    'status_label' => $application->status_label,
                    'created_at' => $application->created_at->format('d M Y H:i'),
                    'village' => $application->village,
                    'district' => $application->district,
                ];
            });

        // Monthly application statistics
        $monthlyStats = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyStats[] = [
                'month' => $date->format('M Y'),
                'applications' => Application::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
                'approved' => Application::whereYear('approved_at', $date->year)
                    ->whereMonth('approved_at', $date->month)
                    ->count(),
            ];
        }

        return view('dashboard', [
            'userRole' => $user->role,
            'stats' => $stats,
            'recentApplications' => $recentApplications,
            'monthlyStats' => $monthlyStats,
        ]);
    }
}