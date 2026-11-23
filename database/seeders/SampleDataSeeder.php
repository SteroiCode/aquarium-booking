<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // Skip if already seeded
        if (DB::table('aquariums')->count() > 0) {
            $this->command->info('Sample data already exists, skipping.');
            return;
        }

        // ── Aquariums ─────────────────────────────────────────────
        DB::table('aquariums')->insert([
            ['name' => 'Ocean Deep Tank',    'location' => 'Hall A - Ground Floor', 'description' => 'A breathtaking 50,000-litre deep-sea exhibit featuring sharks, rays, and exotic tropical fish.',  'price' => 1.00, 'image' => 'aquariums/aquarium1.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Coral Reef Paradise', 'location' => 'Hall B - Ground Floor', 'description' => 'A vibrant 20,000-litre reef aquarium bursting with colourful corals, clownfish, and blue tangs.', 'price' => 1.00, 'image' => 'aquariums/aquarium2.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Freshwater Amazon',  'location' => 'Hall C - First Floor',  'description' => 'Journey through the Amazon River basin showcasing angelfish, discus, and exotic aquatic plants.',  'price' => 1.00, 'image' => 'aquariums/aquarium3.jpg', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ── Fish Species ──────────────────────────────────────────
        DB::table('fish_species')->insert([
            ['name' => 'Clownfish',  'scientific_name' => 'Amphiprion ocellaris',  'description' => 'Famous for its striking orange and white bands, lives symbiotically among sea anemones.', 'tank_size' => 20,  'temperature' => '24-27°C', 'ph_level' => '8.1', 'image' => 'fish_species/clownfish.jpg',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Blue Tang',  'scientific_name' => 'Paracanthurus hepatus',  'description' => 'A vivid royal-blue surgeon fish. Needs plenty of swimming space and excellent water quality.', 'tank_size' => 100, 'temperature' => '23-26°C', 'ph_level' => '8.2', 'image' => 'fish_species/blue_tang.jpg',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Angelfish',  'scientific_name' => 'Pterophyllum scalare',   'description' => 'Graceful triangular freshwater cichlid with long flowing fins.',                               'tank_size' => 80,  'temperature' => '24-30°C', 'ph_level' => '6.5', 'image' => 'fish_species/angelfish.jpg',  'created_at' => now(), 'updated_at' => now()],
        ]);

        // ── Coral & Plants ────────────────────────────────────────
        DB::table('coral_plants')->insert([
            ['name' => 'Brain Coral',    'type' => 'coral', 'description' => 'A large dome-shaped hard coral whose convoluted surface resembles a human brain.', 'light_requirement' => 'High', 'water_flow' => 'Moderate', 'compatibility' => 'Peaceful',    'image' => 'coral_plants/brain_coral.jpg',    'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Staghorn Coral', 'type' => 'coral', 'description' => 'One of the fastest-growing branching corals, vital role as a reef builder.',        'light_requirement' => 'High', 'water_flow' => 'High',     'compatibility' => 'Moderate',    'image' => 'coral_plants/staghorn_coral.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Java Fern',      'type' => 'plant', 'description' => 'A tough slow-growing freshwater fern that thrives in low-light conditions.',         'light_requirement' => 'Low',  'water_flow' => 'Low',      'compatibility' => 'All fish',    'image' => 'coral_plants/java_fern.jpg',      'created_at' => now(), 'updated_at' => now()],
        ]);

        // ── Water Quality ─────────────────────────────────────────
        $aquariumIds = DB::table('aquariums')->pluck('id');
        $waterData   = [];
        foreach ($aquariumIds as $aquariumId) {
            for ($i = 0; $i < 3; $i++) {
                $waterData[] = [
                    'aquarium_id' => $aquariumId,
                    'ph_level'    => round(7.8 + ($i * 0.1), 2),
                    'temperature' => round(25.0 + ($i * 0.5), 2),
                    'ammonia'     => round(0.01 + ($i * 0.005), 3),
                    'nitrite'     => round(0.02 + ($i * 0.005), 3),
                    'nitrate'     => round(5.0  + ($i * 1.0),   3),
                    'salinity'    => round(0.035 + ($i * 0.001), 3),
                    'tested_at'   => Carbon::now()->subDays($i * 7),
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ];
            }
        }
        DB::table('water_qualities')->insert($waterData);

        $this->command->info('✅ Sample data seeded successfully.');
    }
}
