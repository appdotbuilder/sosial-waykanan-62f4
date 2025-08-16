<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssistanceTypeRequest;
use App\Http\Requests\UpdateAssistanceTypeRequest;
use App\Models\AssistanceType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AssistanceTypeController extends Controller
{
    /**
     * Display a listing of assistance types.
     */
    public function index()
    {
        $assistanceTypes = AssistanceType::active()
            ->orderBy('name')
            ->get()
            ->map(function ($type) {
                return [
                    'id' => $type->id,
                    'name' => $type->name,
                    'description' => $type->description,
                    'requirements' => $type->requirements,
                    'max_amount' => $type->max_amount,
                    'max_amount_formatted' => $type->max_amount ? 'Rp ' . number_format($type->max_amount, 0, ',', '.') : null,
                ];
            });

        return Inertia::render('assistance-types/index', [
            'assistanceTypes' => $assistanceTypes,
        ]);
    }

    /**
     * Show the form for creating a new assistance type.
     */
    public function create()
    {
        return Inertia::render('assistance-types/create');
    }

    /**
     * Store a newly created assistance type.
     */
    public function store(StoreAssistanceTypeRequest $request)
    {
        AssistanceType::create($request->validated());

        return redirect()->route('assistance-types.index')
            ->with('success', 'Jenis bantuan berhasil ditambahkan.');
    }

    /**
     * Display the specified assistance type.
     */
    public function show(AssistanceType $assistanceType)
    {
        $applications = $assistanceType->applications()
            ->with('user')
            ->latest()
            ->take(10)
            ->get();

        return Inertia::render('assistance-types/show', [
            'assistanceType' => $assistanceType,
            'applications' => $applications,
        ]);
    }

    /**
     * Show the form for editing the specified assistance type.
     */
    public function edit(AssistanceType $assistanceType)
    {
        return Inertia::render('assistance-types/edit', [
            'assistanceType' => $assistanceType,
        ]);
    }

    /**
     * Update the specified assistance type.
     */
    public function update(UpdateAssistanceTypeRequest $request, AssistanceType $assistanceType)
    {
        $assistanceType->update($request->validated());

        return redirect()->route('assistance-types.show', $assistanceType)
            ->with('success', 'Jenis bantuan berhasil diperbarui.');
    }

    /**
     * Remove the specified assistance type.
     */
    public function destroy(AssistanceType $assistanceType)
    {
        $assistanceType->delete();

        return redirect()->route('assistance-types.index')
            ->with('success', 'Jenis bantuan berhasil dihapus.');
    }
}