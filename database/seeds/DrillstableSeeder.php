<?php


use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DrillstableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i<10; $i++) {
            DB::table('drills')->insert([
                'title' => 'Title'.$i.'aaa',
                'category_name' => 'Category'.$i.'aaa',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_id' => 24
            ]);
        }
    }
}
