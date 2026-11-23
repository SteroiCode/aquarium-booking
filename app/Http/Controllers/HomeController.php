<?php

namespace App\Http\Controllers;

use App\Models\Aquarium;
use App\Models\FishSpecies;
use App\Models\CoralPlant;
use App\Models\WaterQuality;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('search') && $request->search != null) {
            $aquariums = Aquarium::where('name', 'like', '%' . $request->search . '%')
                ->orWhere('location', 'like', '%' . $request->search . '%')
                ->get();
        } else {
            $aquariums = Aquarium::all();
        }

        // Fetch featured items for homepage
        $fishSpecies = FishSpecies::limit(3)->get();
        $coralPlants = CoralPlant::limit(3)->get();
        $waterQualities = WaterQuality::with('aquarium')->latest('tested_at')->get();

        return view('home', compact('aquariums', 'fishSpecies', 'coralPlants', 'waterQualities'));
    }
}