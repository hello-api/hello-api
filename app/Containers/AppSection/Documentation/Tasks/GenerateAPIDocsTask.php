<?php

namespace App\Containers\AppSection\Documentation\Tasks;

use Apiato\Core\Abstracts\Tasks\Task as AbstractTask;
use App\Containers\AppSection\Documentation\Traits\DocsGeneratorTrait;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class GenerateAPIDocsTask extends AbstractTask
{
    use DocsGeneratorTrait;

    public function run($type, $console): string
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

        // execute the command
        $process->run();

        if (!$process->isSuccessful()) {
            $console->error('Error Output: ' . $process->getOutput());
            throw new ProcessFailedException($process);
        }

        // echo the output
        $console->info('[' . $type . '] ' . implode(' ', $command));
        $console->info('Output: ' . $process->getOutput());

        // return the path to the generated documentation
        return $this->getFullDocsUrl($type);
    }
}
