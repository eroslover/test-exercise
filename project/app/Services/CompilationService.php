<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Exercise;
use App\Models\User;

/**
 * Class CompilationService
 *
 * @package App\Services
 */
class CompilationService
{
    /**
     * @param \App\Models\User $user
     */
    public function generate(User $user): void
    {
        /** @var \App\Models\Compilation $compilation */
        $compilation = $user->compilations()->create();

        // Attach to the compilation random exercise of each category.
        Category::query()->get('id')->each(function (Category $category) use ($user, $compilation) {
            /** @var Exercise $exercise */
            $exercise = $this->getRandomExercise($user, $category->id);

            if ($exercise) {
                $compilation->exercises()->attach($exercise);
            }
        });
    }

    /**
     * @param \App\Models\User $user
     * @param int $id
     *
     * @return int
     */
    public function completeExercise(User $user, int $id)
    {
        return $user->actualCompilation?->completeExercise($id);
    }

    /**
     * @param \App\Models\User $user
     * @param int $id
     *
     * @return int
     */
    public function replaceExercise(User $user, int $id)
    {
        /** @var \App\Models\Compilation $userCompilation */
        $userCompilation = $user->actualCompilation;
        $oldExercise = $userCompilation?->exercises()->find($id);

        if (!$oldExercise) {
            return false;
        }

        $newExercise = $this->getRandomExercise($user, $oldExercise->category_id);

        return $userCompilation->replaceExercise($id, $newExercise->id);
    }

    /**
     * @param \App\Models\User $user
     * @param int $categoryId
     *
     * @return \App\Models\Exercise|null
     */
    private function getRandomExercise(User $user, int $categoryId): ?Exercise
    {
        /** @var Exercise $exercise */
        $exercise = Exercise::query()
            ->where('category_id', $categoryId)
            ->whereNotIn('id', $user->exercises()->pluck('exercise_id')->toArray())
            ->inRandomOrder()
            ->first();

        return $exercise;
    }
}
