<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Throwable;

class AbUserMassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ich habe try-catch Block addiert, da wir einige Fehler beim Seeding hatten
        try {

        \App\Models\AbUser::factory()->count(10000)->create();
        echo " Erfolgreich 10.000 Benutzer:innen sind erstellt.\n";

        } catch (Throwable $e) {

        echo "Fehler beim Seeden: " . $e->getMessage() . "\n";
    }

    }
}
