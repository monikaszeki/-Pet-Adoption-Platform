<?php

namespace Database\Seeders;

use App\Models\Pet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class PetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $species = array('dog', 'cat', 'bird', 'other');
        $status = array('available', 'adopted');
        for ($x = 0; $x <= 10; $x++) {
            $created = Pet::create([
                'name' => Str::random(10),
                'age' =>  rand(15, 100),
                'species' => $species[array_rand($species, 1)],
                'breed' =>  Str::random(10),
                'description' => $this->generateRandomString(),
                'status' => $status[array_rand($status, 1)],
                'created_at' => time()
            ]);
            if ($created) {
                DB::table('user_pets')->insert([
                    'user_id' => 1,
                    'pet_id' => $created->id,
                ]);
            }
        }

    }
    public function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }
}
