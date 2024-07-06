<?php

namespace App\Containers\AppSection\Documentation\Tasks;

use Apiato\Core\Abstracts\Tasks\Task as AbstractTask;
use App\Containers\AppSection\Documentation\Traits\DocsGeneratorTrait;
use DateTime;
use Exception;
use RuntimeException;

class RenderTemplatesTask extends AbstractTask
{
    use DocsGeneratorTrait;

    private string $templatePath;
    private string $outputPath;
    // ['templateKey' => value]
    private array $replaceArray;

    public function __construct()
    {
        $this->templatePath = $this->getPathInDocumentationContainer('/Headers/header.template' . config('documentation.locale', 'en') . '.md');
        $this->outputPath = $this->getPathInDocumentationContainer('/UI/WEB/Views/swagger/header.md');
        $this->replaceArray = [
            'api.domain.test' => config('apiato.api.url'),
            '{{rate-limit-expires}}' => config('apiato.api.throttle.expires'),
            '{{rate-limit-attempts}}' => config('apiato.api.throttle.attempts'),
            '{{access-token-expires-in}}' => $this->minutesToTimeDisplay(config('apiato.api.expires-in')),
            '{{access-token-expires-in-minutes}}' => config('apiato.api.expires-in'),
            '{{refresh-token-expires-in}}' => $this->minutesToTimeDisplay(config('apiato.api.refresh-expires-in')),
            '{{refresh-token-expires-in-minutes}}' => config('apiato.api.refresh-expires-in'),
            '{{pagination-limit}}' => config('repository.pagination.limit'),
        ];
    }

    private function minutesToTimeDisplay($minutes): string
    {
        $seconds = $minutes * 60;

        $dtF = new DateTime('@0');
        $dtT = new DateTime("@$seconds");

        return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');
    }

    /**
     * Read the markdown header template and fill it with some real data from the .env file.
     *
     * @throws Exception
     */
    public function run(): string
    {
        // read the template file
        try {
            $headerMarkdownContent = file_get_contents($this->templatePath);
        } catch (Exception) {
            throw new Exception('Could not read header template file', 500);
        }

        $headerMarkdownContent = $this->replaceMarkdownContent($headerMarkdownContent, $this->replaceArray);

        $this->fileForceContents($this->outputPath, $headerMarkdownContent);

        return $this->outputPath;
    }

    private function replaceMarkdownContent(string $markdownContent, array $replaceArray): array|string
    {
        foreach ($replaceArray as $search => $replace) {
            $markdownContent = str_replace($search, $replace, $markdownContent);
        }

        return $markdownContent;
    }

    // file_put_contents() fails if you try to put a file in a directory that doesn't exist.
    // this creates the directory if it doesn't exist.
    private function fileForceContents(string $dir, string $contents): void
    {
        $parts = explode('/', $dir);
        $file = array_pop($parts);
        $dir = '';

        foreach ($parts as $key => $part) {
            if (0 === $key) {
                continue;
            }

            $dir .= "/{$part}";
            if (!is_dir($dir) && !mkdir($dir)) {
                throw new RuntimeException(sprintf('Directory "%s" was not created', $dir));
            }
        }
        file_put_contents("{$dir}/{$file}", $contents);
    }
}
