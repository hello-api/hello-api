<?php

namespace App\Containers\AppSection\Documentation\Actions;

use Apiato\Core\Abstracts\Actions\Action as AbstractAction;
use App\Containers\AppSection\Documentation\Tasks\GenerateOpenApiSpecTask;
use App\Containers\AppSection\Documentation\Tasks\GetAllDocsTypesTask;
use App\Containers\AppSection\Documentation\Tasks\RenderApidocJsonTask;
use App\Containers\AppSection\Documentation\Tasks\RenderTemplatesTask;
use App\Containers\AppSection\Documentation\Traits\DocsGeneratorTrait;
use App\Containers\AppSection\Documentation\UI\CLI\Commands\GenerateApiDocsCommand;

class GenerateOpenApiDocumentationAction extends AbstractAction
{
    use DocsGeneratorTrait;

    public function __construct(
        private readonly GenerateApiDocsCommand $console,
    ) {
    }

    final public function run(): void
    {
        $types = app(GetAllDocsTypesTask::class)->run();

//        $this->removeOldConfigs();

//        foreach ($types as $type) {
//            app(RenderApidocJsonTask::class, ['docType' => $type])->run();
//        }

//        app(RenderTemplatesTask::class)->run();

//        $this->console->info('Generating API Documentations for (' . implode(' & ', $types) . ")\n");

        $documentationUrls = array_map(static function ($type) {
            return app(GenerateOpenApiSpecTask::class)->run($type);
        }, $types);

//        $this->console->info("Done! You can access your API Docs at: \n" . implode("\n", $documentationUrls));
    }

    private function removeOldConfigs(): void
    {
        $files = glob($this->getApiDocJsConfigsPath() . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
}
