<?php

namespace App\Models;

use App\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Task[] $tasks
 * @property-read int|null $tasks_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = ["name", "slug"];

    public function getRouteKeyName()
    {
        return "slug";
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public static function register(array $names) : Collection
    {
        $categoriesSaved = collect([]);

        $names = array_filter(array_unique($names));
        $categoriesNames = static::getCategoriesToRegister($names);

        foreach ($categoriesNames as $name) {
            $categoriesSaved[] = static::create([
                "name" => trim($name),
                "slug" => Str::slug(trim($name))
            ]);
        }

        return $categoriesSaved;
    }

    public static function getCategoriesToRegister(array $names) : array
    {
        $existingCategoriesNames = static::whereIn("name", $names)->pluck("name");

        return array_filter($names, function ($name) use ($existingCategoriesNames) {
            return ! $existingCategoriesNames->contains($name);
        });
    }
}
