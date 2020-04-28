<?php

use Illuminate\Database\Seeder;

class AssociationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Association::class, 50)->create();
    }
}
