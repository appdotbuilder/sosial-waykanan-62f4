<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use App\Models\Application;
use App\Models\AssistanceType;
use Illuminate\Http\Request;


class ApplicationController extends Controller
{
    /**
     * Display a listing of applications.
     */
    public function index(Request $request)
    {
        $query = Application::with(['user', 'assistanceType', 'reviewer']);

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by assistance type if provided
        if ($request->filled('assistance_type')) {
            $query->where('assistance_type_id', $request->assistance_type);
        }

        // Search by application number or applicant name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('application_number', 'like', "%{$search}%")
                  ->orWhere('applicant_name', 'like', "%{$search}%");
            });
        }

        // Filter by user's own applications for citizens
        if ($request->user()->role === 'citizen') {
            $query->where('user_id', $request->user()->id);
        }

        $applications = $query->latest()->paginate(10);

        $assistanceTypes = AssistanceType::active()->get(['id', 'name']);

        return view('applications.index', [
            'applications' => $applications,
            'assistanceTypes' => $assistanceTypes,
            'filters' => [
                'status' => $request->status,
                'assistance_type' => $request->assistance_type,
                'search' => $request->search,
            ],
        ]);
    }

    /**
     * Show the form for creating a new application.
     */
    public function create()
    {
        $assistanceTypes = AssistanceType::active()->get();

        return view('applications.create', [
            'assistanceTypes' => $assistanceTypes,
        ]);
    }

    /**
     * Store a newly created application.
     */
    public function store(StoreApplicationRequest $request)
    {
        $application = Application::create([
            ...$request->validated(),
            'user_id' => $request->user()->id,
            'status' => 'draft',
        ]);

        return redirect()->route('applications.show', $application)
            ->with('success', 'Pengajuan bantuan berhasil dibuat. Silakan lengkapi dokumen pendukung.');
    }

    /**
     * Display the specified application.
     */
    public function show(Application $application)
    {
        // Check authorization
        if (auth()->user()->role === 'citizen' && $application->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke pengajuan ini.');
        }

        $application->load([
            'user',
            'assistanceType',
            'reviewer',
            'documents',
            'fieldSurvey.surveyor',
            'fieldSurvey.photos'
        ]);

        return view('applications.show', [
            'application' => $application,
        ]);
    }

    /**
     * Show the form for editing the specified application.
     */
    public function edit(Application $application)
    {
        // Only allow editing draft applications by owner
        if ($application->status !== 'draft' || $application->user_id !== auth()->id()) {
            abort(403, 'Pengajuan ini tidak dapat diedit.');
        }

        $assistanceTypes = AssistanceType::active()->get();

        return view('applications.edit', [
            'application' => $application,
            'assistanceTypes' => $assistanceTypes,
        ]);
    }

    /**
     * Update the specified application.
     */
    public function update(UpdateApplicationRequest $request, Application $application)
    {
        $validated = $request->validated();
        
        // Handle submit action
        if ($request->has('submit') && $request->submit === 'true') {
            // Only allow submitting draft applications by owner
            if ($application->status !== 'draft' || $application->user_id !== auth()->id()) {
                abort(403, 'Pengajuan ini tidak dapat diajukan.');
            }
            
            $application->update([
                'status' => 'submitted',
                'submitted_at' => now(),
            ]);
            
            return redirect()->route('applications.show', $application)
                ->with('success', 'Pengajuan bantuan berhasil diajukan untuk ditinjau.');
        }
        
        // Regular update
        // Only allow updating draft applications by owner
        if ($application->status !== 'draft' || $application->user_id !== auth()->id()) {
            abort(403, 'Pengajuan ini tidak dapat diedit.');
        }

        $application->update($validated);

        return redirect()->route('applications.show', $application)
            ->with('success', 'Pengajuan bantuan berhasil diperbarui.');
    }



    /**
     * Remove the specified application.
     */
    public function destroy(Application $application)
    {
        // Only allow deleting draft applications by owner or admin/officer
        if (auth()->user()->role === 'citizen') {
            if ($application->status !== 'draft' || $application->user_id !== auth()->id()) {
                abort(403, 'Pengajuan ini tidak dapat dihapus.');
            }
        }

        $application->delete();

        return redirect()->route('applications.index')
            ->with('success', 'Pengajuan bantuan berhasil dihapus.');
    }
}