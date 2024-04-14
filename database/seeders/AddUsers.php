<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Phone;
use App\Models\User;
use Illuminate\Database\Seeder;

class AddUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i <= 10; $i++) {
            $newUser = new User();
            $newUser->meno = "Jano_" . mt_rand(1, 50000);
            $newUser->email = "jano_" . mt_rand(1, 50000) . "@gmail.com";
            $newUser->save();

            $newPhone = new Phone();
            $newPhone->phone = "+421" . mt_rand(5, 55555);
            $newPhone->user_id = $newUser->id;
            $newPhone->save();

            for ($j = 0; $j < 4; $j++) {
                $newAddress = new Address();
                $newAddress->street = "Dlha";
                $newAddress->street_number = $j + mt_rand(1, 100);
                $newAddress->city = "Nitra";
                $newAddress->zip = "98514";
                $newAddress->user_id = $newUser->id;
                $newAddress->save();
            }
        }
    }
}
