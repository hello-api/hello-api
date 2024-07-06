<?php

namespace App\Containers\AppSection\Documentation\Tasks;

use Apiato\Core\Abstracts\Tasks\Task as AbstractTask;
use App\Containers\AppSection\Documentation\Traits\DocsGeneratorTrait;
use App\Containers\AppSection\Documentation\UI\CLI\Commands\GenerateOpenApiSpecCommand;
use MohammadAlavi\LaravelOpenApi\Generator;

class GenerateOpenApiSpecTask extends AbstractTask
{
    use DocsGeneratorTrait;

    public function __construct(
        private readonly Generator $generator,
    ) {
    }

    final public function run(string $type, GenerateOpenApiSpecCommand $console): string
    {
        $path = $this->getDocumentationPath($type);

        //        $command = [
        //            $this->getExecutable(),
        //            '-c',
        //            $this->getJsonFilePath($type),
        //            ...$this->getEndpointFiles($type),
        //            '-i',
        //            'app',
        //            '-o',
        //            $path,
        //            '--single',
        //        ];
        //
        //        $process = new Process($command);
        //
        //        $process->run();

        $this->handle($type, $console);

        //        if (!$process->isSuccessful()) {
        //            $console->error('Error Output: ' . $process->getOutput());
        //            throw new ProcessFailedException($process);
        //        }

        $console->info("'[{$type}]'");
        //        $console->info('[' . $type . '] ' . implode(' ', $command));
        //        $console->info('Output: ' . $console->getOutput());

        return $this->getFullDocsUrl($type);
    }

    private function handle(string $type, GenerateOpenApiSpecCommand $console): void
    {
        //        $collectionExists = collect(config('openapi.collections'))->has($console->argument('collection'));
        //
        //        if (!$collectionExists) {
        //            $console->error('Collection "' . $console->argument('collection') . '" does not exist.');
        //
        //            return;
        //        }

        $json = $this->generator->generate($type)->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        //        $json = $this->generator->generate($console->argument('collection'))->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $path = app_path("Containers/AppSection/Documentation/UI/WEB/Views/swagger/openapi.{$type}.json");
        file_put_contents($path, $json);
    }
}
