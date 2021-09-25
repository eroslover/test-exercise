<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CompilationExercise
 *
 * @package App\Models
 */
class CompilationExercise extends Model
{
    use HasFactory;

    protected $table = 'compilation_exercise';

    /**
     * @var string[]
     */
    protected $fillable = [
        'compilation_id',
        'exercise_id',
        'status',
    ];
}
