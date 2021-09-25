<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\ExerciseStatusEnum;

class CreateCompilationExerciseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compilation_exercise', function (Blueprint $table) {
            $table->id();
            $table->integer('compilation_id');
            $table->integer('exercise_id');
            $table->enum('status', ExerciseStatusEnum::getStatuses())->default(ExerciseStatusEnum::PENDING);
            $table->foreign('compilation_id')->references('id')->on('compilations');
            $table->foreign('exercise_id')->references('id')->on('exercises');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compilation_exercise');
    }
}
