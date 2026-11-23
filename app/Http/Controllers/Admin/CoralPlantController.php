<?php

namespace App\Http\Controllers\Admin;

use App\Models\CoralPlant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CoralPlantController extends Controller
{
    /**
     * Display a listing of coral & plants.
     */
    public function index()
    {
        $coralPlants = CoralPlant::all();
        return view('admin.coral_plants.index', compact('coralPlants'));
    }

    /**
     * Show the form for creating a new coral & plant.
     */
    public function create()
    {
        return view('admin.coral_plants.create');
    }

    /**
     * Store a newly created coral & plant in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:coral,plant',
            'description' => 'nullable|string',
            'light_requirement' => 'required|string',
            'water_flow' => 'required|string',
            'compatibility' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('coral_plants', 'public');
        }

        CoralPlant::create($validated);

        return redirect()->route('admin.coral_plants.index')
            ->with('success', 'Coral & Plant added successfully!');
    }

    /**
     * Show the form for editing the specified coral & plant.
     */
    public function edit($id)
    {
        $coralPlant = CoralPlant::findOrFail($id);
        return view('admin.coral_plants.edit', compact('coralPlant'));
    }

    /**
     * Update the specified coral & plant in storage.
     */
    public function update(Request $request, $id)
    {
        $coralPlant = CoralPlant::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:coral,plant',
            'description' => 'nullable|string',
            'light_requirement' => 'required|string',
            'water_flow' => 'required|string',
            'compatibility' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($coralPlant->image) {
                \Storage::disk('public')->delete($coralPlant->image);
            }
            $validated['image'] = $request->file('image')->store('coral_plants', 'public');
        }

        $coralPlant->update($validated);

        return redirect()->route('admin.coral_plants.index')
            ->with('success', 'Coral & Plant updated successfully!');
    }

    public function destroy($id)
    {
        $coralPlant = CoralPlant::findOrFail($id);
        if ($coralPlant->image) {
            \Storage::disk('public')->delete($coralPlant->image);
        }
        $coralPlant->delete();

        return redirect()->route('admin.coral_plants.index')
            ->with('success', 'Coral & Plant deleted successfully!');
    }
}