<?php

namespace App\Models;

use App\Enums\ExerciseStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Compilation
 *
 * @property int $id
 * @property string $title
 * @property int $user_id
 * @property $exercises
 *
 * @package App\Models
 */
class Compilation extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->title = 'Compilation #' . self::query()->where('user_id', $model->user_id)->count('id') + 1;
        });
    }

    /**
     * Complete exercise of actual compilation.
     *
     * @param int $id
     *
     * @return int
     */
    public function completeExercise(int $id): int
    {
        return $this->exercises()->updateExistingPivot($id, [
            'status' => ExerciseStatusEnum::COMPLETED,
        ]);
    }

    /**
     * Replace exercise of actual compilation with other one.
     *
     * @param int $id
     *  Subject
     * @param int $newId
     *  Replacement
     *
     * @return int
     */
    public function replaceExercise(int $id, int $newId): int
    {
        return $this->exercises()->updateExistingPivot($id, [
            'exercise_id' => $newId,
            'status' => ExerciseStatusEnum::PENDING,
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function exercises()
    {
        return $this->belongsToMany(Exercise::class)->withPivot('status')->with('category');
    }
}
