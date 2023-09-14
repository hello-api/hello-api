<?php

namespace App\Containers\AppSection\Documentation\UI\CLI\Commands;

use Apiato\Core\Abstracts\Commands\ConsoleCommand as AbstractConsoleCommand;
use App\Containers\AppSection\Documentation\Actions\GenerateOpenApiDocumentationAction;

class GenerateOpenApiSpecCommand extends AbstractConsoleCommand
{
    protected $signature = 'apiato:openapi';
    protected $description = 'Generate OpenAPI specification';

    public function handle(): void
    {
        app(GenerateOpenApiDocumentationAction::class)->run($this);
    }
}
