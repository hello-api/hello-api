<?php

namespace App\Containers\AppSection\Documentation\UI\CLI\Commands;

use Apiato\Core\Abstracts\Commands\ConsoleCommand as AbstractConsoleCommand;
use App\Containers\AppSection\Documentation\Actions\GenerateDocumentationAction;

class GenerateApiDocsCommand extends AbstractConsoleCommand
{
    protected $signature = 'apiato:openapi';
    protected $description = 'Generate API Documentations with (API-Doc-JS)';

    final public function handle(): void
    {
        app(GenerateDocumentationAction::class)->run($this);
    }
}
