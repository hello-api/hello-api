<?php

namespace App\Containers\AppSection\Documentation\Actions;

use Apiato\Core\Abstracts\Actions\Action as AbstractAction;
use App\Containers\AppSection\Documentation\Tasks\GenerateOpenApiSpecTask;
use App\Containers\AppSection\Documentation\Tasks\GetAllDocsTypesTask;
use App\Containers\AppSection\Documentation\Tasks\RenderTemplatesTask;
use App\Containers\AppSection\Documentation\Traits\DocsGeneratorTrait;
use App\Containers\AppSection\Documentation\UI\CLI\Commands\GenerateOpenApiSpecCommand;

class GenerateOpenApiDocumentationAction extends AbstractAction
{
    use DocsGeneratorTrait;

    final public function run(GenerateOpenApiSpecCommand $console): void
    {
        $types = app(GetAllDocsTypesTask::class)->run();

        app(RenderTemplatesTask::class)->run();

        $console->info('Generating API Documentations for (' . implode(' & ', $types) . ")\n");

        $documentationUrls = array_map(static function ($type) use ($console) {
            return app(GenerateOpenApiSpecTask::class)->run($type, $console);
        }, $types);

        $console->info("Done! You can access your API Docs at: \n" . implode("\n", $documentationUrls));
    }
}
