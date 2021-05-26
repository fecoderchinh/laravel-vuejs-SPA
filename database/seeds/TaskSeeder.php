<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $cover_path = "/cover.jpg";

        Category::factory()->count(5)->create();

        for ($i = 0; $i < 20; $i++) {

            $category = Category::find(random_int(2, 5));

            $title = $faker->sentence("5");

            $post = $category->tasks()->create([
                "title" => $title,
                "slug"  => Str::slug($title),
                "content"  => $faker->text,
                "category_id" => random_int(2, 5),
                "user_id" => User::factory()->create()->id,
                "online" => (bool) random_int(0, 1),
                "cover_path" => $cover_path,
                "visits" => random_int(0, 50)
            ]);

            Comment::factory()->count(random_int(0, 4))->create(["task_id" => $post->id, "user_id" => User::factory()->create()->id]);
        }
    }
}
