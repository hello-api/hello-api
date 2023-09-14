<?php

namespace App\Containers\AppSection\Documentation\Tasks;

use Apiato\Core\Abstracts\Tasks\Task as AbstractTask;
use App\Containers\AppSection\Documentation\Traits\DocsGeneratorTrait;
use App\Containers\AppSection\Documentation\UI\CLI\Commands\GenerateApiDocsCommand;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Vyuldashev\LaravelOpenApi\Generator;

class GenerateOpenApiSpecTask extends AbstractTask
{
    use DocsGeneratorTrait;

    public function __construct(
        private readonly GenerateApiDocsCommand $console,
        private readonly Generator $generator,
    ) {
    }

    final public function run(string $type): string
    {
        $path = $this->getDocumentationPath($type);

        $command = [
            $this->getExecutable(),
            '-c',
            $this->getJsonFilePath($type),
            ...$this->getEndpointFiles($type),
            '-i',
            'app',
            '-o',
            $path,
            '--single',
        ];

        $process = new Process($command);

        $process->run();

        $this->handle($type);

        if (!$this->console->isSuccessful()) {
            $this->console->error('Error Output: ' . $this->console->getOutput());
        }

        if (!$process->isSuccessful()) {
            $this->console->error('Error Output: ' . $process->getOutput());
            throw new ProcessFailedException($process);
        }

        $this->console->info("'[{$type}]'");
        $this->console->info('Output: ' . $this->console->getOutput());

        return $this->getFullDocsUrl($type);
    }

    private function handle(string $type): void
    {
        $collectionExists = collect(config('openapi.collections'))->has($this->console->argument('collection'));

        if (!$collectionExists) {
            $this->console->error('Collection "' . $this->console->argument('collection') . '" does not exist.');

            return;
        }

        $json = $this->generator->generate($this->console->argument('collection'))->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $path = app_path("'Containers/AppSection/Documentation/UI/WEB/Views/swagger/openapi.{$type}.json'");
        file_put_contents($path, $json);
    }
}
