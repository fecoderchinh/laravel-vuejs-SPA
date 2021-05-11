<?php

namespace Database\Factories;

use App\Models\Category;
use App\Task;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence("5");
        return [
            "title" => $title,
            "slug"  => Str::slug($title),
            "content"  => $this->faker->text,
            "category_id" => Category::factory()->create()->id,
            "user_id" => User::factory()->create()->id,
            "online" => true,
//            "cover_path" => asset("/storage/covers/cover.jpg"),
            "cover_path" => "/cover.jpg",
            "visits" => 0
        ];
    }
}
