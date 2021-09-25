<?php

namespace App\Enums;

/**
 * Class ExerciseStatusEnum
 *
 * @package App\Enums
 */
class ExerciseStatusEnum
{
    const PENDING = 'pending';
    const IN_PROGRESS = 'in_progress';
    const ON_PAUSE = 'on_pause';
    const COMPLETED = 'completed';

    /**
     * @return string[]
     */
    public static function getStatuses(): array
    {
        return [
            self::PENDING,
            self::IN_PROGRESS,
            self::ON_PAUSE,
            self::COMPLETED,
        ];
    }
}
