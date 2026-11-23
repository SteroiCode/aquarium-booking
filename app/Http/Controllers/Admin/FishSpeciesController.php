<?php

namespace App\Http\Controllers\Admin;

use App\Models\FishSpecies;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FishSpeciesController extends Controller
{
    /**
     * Display a listing of fish species.
     */
    public function index()
    {
        $fishSpecies = FishSpecies::all();
        return view('admin.fish_species.index', compact('fishSpecies'));
    }

    /**
     * Show the form for creating a new fish species.
     */
    public function create()
    {
        return view('admin.fish_species.create');
    }

    /**
     * Store a newly created fish species in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'scientific_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tank_size' => 'required|integer',
            'temperature' => 'required|string',
            'ph_level' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('fish_species', 'public');
        }

        FishSpecies::create($validated);

        return redirect()->route('admin.fish_species.index')
            ->with('success', 'Fish species added successfully!');
    }

    /**
     * Show the form for editing the specified fish species.
     */
    public function edit($id)
    {
        $fishSpecies = FishSpecies::findOrFail($id);
        return view('admin.fish_species.edit', compact('fishSpecies'));
    }

    /**
     * Update the specified fish species in storage.
     */
    public function update(Request $request, $id)
    {
        $fishSpecies = FishSpecies::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'scientific_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tank_size' => 'required|integer',
            'temperature' => 'required|string',
            'ph_level' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($fishSpecies->image) {
                \Storage::disk('public')->delete($fishSpecies->image);
            }
            $validated['image'] = $request->file('image')->store('fish_species', 'public');
        }

        $fishSpecies->update($validated);

        return redirect()->route('admin.fish_species.index')
            ->with('success', 'Fish species updated successfully!');
    }

    public function destroy($id)
    {
        $fishSpecies = FishSpecies::findOrFail($id);
        if ($fishSpecies->image) {
            \Storage::disk('public')->delete($fishSpecies->image);
        }
        $fishSpecies->delete();

        return redirect()->route('admin.fish_species.index')
            ->with('success', 'Fish species deleted successfully!');
    }
}