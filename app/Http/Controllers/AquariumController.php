<?php

namespace App\Http\Controllers;

use App\Models\Aquarium;
use Illuminate\Http\Request;

class AquariumController extends Controller
{
    public function index()
    {
        $aquariums = Aquarium::all();
        return view('admin.aquariums.index', compact('aquariums'));
    }

    public function create()
    {
        return view('admin.aquariums.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image'
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('aquariums', 'public');
        }

        Aquarium::create($data);

        return redirect()->route('admin.aquariums.index')  // ← CHANGE THIS
            ->with('success', 'Aquarium added successfully!');
    }

    public function edit($id)
    {
        $aquarium = Aquarium::findOrFail($id);
        return view('admin.aquariums.edit', compact('aquarium'));
    }

    public function update(Request $request, $id)
    {
        $aquarium = Aquarium::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image'
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('aquariums', 'public');
        }

        $aquarium->update($data);

        return redirect()->route('admin.aquariums.index')  // ← CHANGE THIS
            ->with('success', 'Aquarium updated successfully!');
    }

    public function destroy($id)
    {
        $aquarium = Aquarium::findOrFail($id);
        $aquarium->delete();

        return redirect()->route('admin.aquariums.index')  // ← CHANGE THIS
            ->with('success', 'Aquarium deleted successfully!');
    }
}