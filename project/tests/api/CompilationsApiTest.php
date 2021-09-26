<?php

use Tests\ApiTestCase;
use App\Services\CompilationService;
use App\Enums\ExerciseStatusEnum;

/**
 * Class CompilationsApiTest
 */
class CompilationsApiTest extends ApiTestCase
{
    /**
     * @var \App\Services\CompilationService
     */
    private CompilationService $service;

    protected function _before()
    {
        parent::_before();

        $this->service = app(CompilationService::class);
    }

    protected function _after()
    {

    }

    public function testGettingActualCompilation()
    {
        // Since user doesn't have compilations yet it should be generated automatically before response.
        $this->tester->sendGet('compilations/get-actual');
        $result = json_decode($this->tester->grabResponse(), true);

        $this->assertNotEmpty($result);

        for ($i = 0; $i < 10; $i++) {
            $this->service->generate($this->user);
        }

        $latestCompilation = $this->service->generate($this->user);

        $this->tester->sendGet('compilations/get-actual');
        $result = json_decode($this->tester->grabResponse(), true);

        $this->assertEquals($latestCompilation->id, $result['data']['id']);
    }

    public function testExerciseCompleting()
    {
        $compilation = $this->service->generate($this->user);
        $randomExercise = $compilation->exercises()->inRandomOrder()->first();

        $this->assertEquals(ExerciseStatusEnum::PENDING, $randomExercise->pivot->status);

        $this->tester->sendPut("compilations/complete-exercise/{$randomExercise->id}");
        $result = json_decode($this->tester->grabResponse(), true);

        $this->assertTrue($result['status']);

        $completedExercise = $compilation->exercises()->find($randomExercise->id);

        $this->assertEquals(ExerciseStatusEnum::COMPLETED, $completedExercise->pivot->status);
    }

    public function testExerciseReplacing()
    {
        $compilation = $this->service->generate($this->user);
        $exercise = $compilation->exercises()->first();

        $this->tester->sendPut("compilations/replace-exercise/{$exercise->id}");
        json_decode($this->tester->grabResponse(), true);

        $this->assertEmpty($compilation->exercises()->find($exercise->id));
        $this->assertNotEquals($exercise->id, $compilation->exercises()->first()->id);
    }
}
