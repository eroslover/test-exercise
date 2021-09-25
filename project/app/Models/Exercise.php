<?php

namespace App\Models;

use Database\Factories\ExerciseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Exercise
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $category_id
 * @property $category
 * @property $compilations
 *
 * @package App\Models
 */
class Exercise extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'description',
        'category_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function compilations()
    {
        return $this->belongsToMany(Compilation::class);
    }

    /**
     * @return \Database\Factories\ExerciseFactory
     */
    protected static function newFactory()
    {
        return ExerciseFactory::new();
    }
}
