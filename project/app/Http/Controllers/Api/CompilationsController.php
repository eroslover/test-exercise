<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompilationResource;
use App\Services\CompilationService;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;

/**
 * Class CompilationsController
 *
 * @package App\Http\Controllers\Api
 */
class CompilationsController extends Controller
{
    /**
     * @var \App\Services\CompilationService
     */
    private CompilationService $service;

    /**
     * @var \Illuminate\Routing\ResponseFactory
     */
    private ResponseFactory $response;

    /**
     * CompilationsController constructor.
     *
     * @param \App\Services\CompilationService $service
     * @param \Illuminate\Routing\ResponseFactory $response
     */
    public function __construct(CompilationService $service, ResponseFactory $response)
    {
        $this->service = $service;
        $this->response = $response;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getActual(Request $request)
    {
        $compilation = $request->user()->actualCompilation;

        if (!$compilation) {
            $this->service->generate($request->user());
            $compilation = $request->user()->actualCompilation;
        }

        return $this->response->json([
            'data' => new CompilationResource($compilation),
            'status' => true,
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function completeExercise(Request $request, int $id)
    {
        /** @var \App\Models\Exercise $exercise */
        $status = $this->service->completeExercise($request->user(), $id);

        return $this->response->json([
            'status' => (bool) $status,
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function replaceExercise(Request $request, int $id)
    {
        /** @var \App\Models\Exercise $exercise */
        $status = $this->service->replaceExercise($request->user(), $id);

        return $this->response->json([
            'status' => (bool) $status,
        ]);
    }
}
