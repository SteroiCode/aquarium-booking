<?php

namespace App\Http\Controllers\Admin;

use App\Models\WaterQuality;
use App\Models\Aquarium;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WaterQualityController extends Controller
{
    /**
     * Display a listing of water quality records.
     */
    public function index()
    {
        $waterQualities = WaterQuality::with('aquarium')->get();
        $aquariums = Aquarium::all();
        return view('admin.water_quality.index', compact('waterQualities', 'aquariums'));
    }

    /**
     * Show the form for creating a new water quality record.
     */
    public function create()
    {
        $aquariums = Aquarium::all();
        return view('admin.water_quality.create', compact('aquariums'));
    }

    /**
     * Store a newly created water quality record in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'aquarium_id' => 'required|exists:aquariums,id',
            'ph_level' => 'required|numeric|min:0|max:14',
            'temperature' => 'required|numeric',
            'ammonia' => 'required|numeric|min:0',
            'nitrite' => 'required|numeric|min:0',
            'nitrate' => 'required|numeric|min:0',
            'salinity' => 'nullable|numeric',
            'tested_at' => 'required|date',
        ]);

        WaterQuality::create($validated);

        return redirect()->route('admin.water_quality.index')
            ->with('success', 'Water quality record added successfully!');
    }

    /**
     * Show the form for editing the specified water quality record.
     */
    public function edit($id)
    {
        $waterQuality = WaterQuality::findOrFail($id);
        $aquariums = Aquarium::all();
        return view('admin.water_quality.edit', compact('waterQuality', 'aquariums'));
    }

    /**
     * Update the specified water quality record in storage.
     */
    public function update(Request $request, $id)
    {
        $waterQuality = WaterQuality::findOrFail($id);

        $validated = $request->validate([
            'aquarium_id' => 'required|exists:aquariums,id',
            'ph_level' => 'required|numeric|min:0|max:14',
            'temperature' => 'required|numeric',
            'ammonia' => 'required|numeric|min:0',
            'nitrite' => 'required|numeric|min:0',
            'nitrate' => 'required|numeric|min:0',
            'salinity' => 'nullable|numeric',
            'tested_at' => 'required|date',
        ]);

        $waterQuality->update($validated);

        return redirect()->route('admin.water_quality.index')
            ->with('success', 'Water quality record updated successfully!');
    }

    /**
     * Remove the specified water quality record from storage.
     */
    public function destroy($id)
    {
        $waterQuality = WaterQuality::findOrFail($id);
        $waterQuality->delete();

        return redirect()->route('admin.water_quality.index')
            ->with('success', 'Water quality record deleted successfully!');
    }
}