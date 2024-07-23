<?php

namespace Database\Seeders;

use App\Models\Pacient;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Pacient::factory(1000)->create();

        $dataInceput = Carbon::now()->setDate(2024, 6, 01)->setTime(8, 0, 0, 0);
        // $dataSfarsit = Carbon::now()->setDate(2024, 7, 26)->setTime(19, 0, 0, 0);
        $dataSfarsit = Carbon::now()->setDate(2024, 8, 31)->setTime(19, 0, 0, 0);

        \App\Models\Programare::truncate();

        while ($dataInceput->lte($dataSfarsit)) {
            // Minute consultatie
            $numbers = array(20, 25, 30);
            $randomKey = array_rand($numbers);
            $randomNumber = $numbers[$randomKey];

            \App\Models\Programare::insert([
                'specializare_id' => 6,
                'medic_id' => 4,
                'data' => $dataInceput,
                'de_la' => $dataInceput->isoFormat('HH:mm'),
                'pana_la' => $dataInceput->addMinutes($randomNumber)->isoFormat('HH:mm'),
                'pacient_id' => Pacient::inRandomOrder()->first()->id,
                'notita' => 'Notiță ' . Str::random(3),
                'cabinet_id' => \App\Models\Cabinet::inRandomOrder()->first()->id,
            ]);

            // If is the end of the working day
            if ($dataInceput->hour >= 19) {
                // We go to next day
                $dataInceput->addDay()->setTime(8, 0, 0, 0);

                // If next day is Saturday, 2 more days will be added to go to Monday
                $dataInceput->isSaturday() ? $dataInceput->addDays(2) : null;
            }
        }

    }
}
