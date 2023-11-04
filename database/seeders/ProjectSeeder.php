<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Type;

use App\Models\Project;


use Faker\Generator as Faker;

use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        $types = Type::all()->pluck('id');

        for ($i = 0; $i < 10; $i++) {

            $type_id = $faker->randomElement($types);

            $project = new Project();
            $project->name = $faker->sentence(2, true);

           
            $project->type_id = $faker->boolean(60) ? $type_id : null;
            $project->slug = Str::slug($project->name);
            $project->git_url = $faker->url();
            $project->description = $faker->paragraph(2, true);
            $project->created_at = $faker->dateTime();
            $project->save();
            
        }
    }
}