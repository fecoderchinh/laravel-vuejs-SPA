<?php

namespace App\Models;

use App\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * App\Models\Tag
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|Task[] $tasks
 * @property-read int|null $tasks_count
 * @method static \Database\Factories\TagFactory factory(...$parameters)
 */
class Tag extends Model
{
    use HasFactory;

    protected $fillable = ["name", "slug"];

    public function getRouteKeyName()
    {
        return "slug";
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }

    public static function add(array $tagNames) : Collection
    {
        $tagNames = array_map('trim', array_unique($tagNames));

        $tagToInsert = static::getTagToInsert($tagNames);

        static::addMany($tagToInsert);

        return static::whereIn("name", $tagNames)->pluck("id");
    }

    private static function getTagToInsert(array $tagNames)
    {
        $existingTags = static::whereIn("name", $tagNames)->pluck("name");

        return array_filter($tagNames, function ($name) use ($existingTags) {
            return ! $existingTags->contains($name) && $name !== "";
        });
    }

    private static function addMany(array $tags) : void
    {
        $tagsToInsert = array_map(function($name) {
            return [
                "name" => trim($name),
                "slug" => Str::slug(trim($name))
            ];
        }, $tags);

        static::insert($tagsToInsert);
    }
}
