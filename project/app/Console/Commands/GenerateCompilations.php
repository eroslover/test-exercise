<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\CompilationService;
use Illuminate\Console\Command;

/**
 * Class GenerateCompilations
 *
 * @package App\Console\Commands
 */
class GenerateCompilations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'compilations:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate compilation for each user';

    /**
     * @var \App\Services\CompilationService
     */
    private CompilationService $service;

    /**
     * Create a new command instance.
     *
     * @param \App\Services\CompilationService $service
     */
    public function __construct(CompilationService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        User::query()->cursor()->each(fn(User $user) => $this->service->generate($user));
        $this->info('Compilations have been generated successfully.');
    }
}
