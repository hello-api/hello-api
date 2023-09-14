<?php

namespace App\Containers\AppSection\Documentation\Tasks;

use Apiato\Core\Abstracts\Tasks\Task as AbstractTask;
use App\Containers\AppSection\Documentation\Traits\DocsGeneratorTrait;

class RenderApidocJsonTask extends AbstractTask
{
    use DocsGeneratorTrait;

    private string $templatePath;
    private string $outputPath;
    private array $replaceArray;

    public function __construct(string $docType)
    {
        $this->templatePath = $this->getPathInDocumentationContainer('/ApiDocJs/apidoc.template.json');
        $this->outputPath = $this->getJsonFilePath($docType);
        $this->replaceArray = [
            'name' => config('app.name'),
            'description' => config('app.name') . ' (' . ucfirst($docType) . ' API) Documentation',
            'title' => 'Welcome to ' . config('app.name'),
            'url' => $this->getFullUrl(),
            'sampleUrl' => config('documentation.enable-sending-sample-request') ? $this->getFullUrl() : null,
        ];
    }

    private function getFullUrl(): string
    {
        return config('apiato.api.url') . $this->prepareUrlPrefix();
    }

    private function prepareUrlPrefix(): string
    {
        return rtrim(config('apiato.api.prefix'), '/');
    }

    /**
     * Read the markdown header template and fill it with some real data from the .env file.
     *
     * @throws \JsonException
     */
    public function run(): string
    {
        // read the template file
        $jsonContent = file_get_contents($this->templatePath);

        // decode the JSON data into a PHP array.
        $contentsDecoded = json_decode($jsonContent, true, 512, JSON_THROW_ON_ERROR);

        // modify the variables.
        foreach ($this->replaceArray as $key => $value) {
            $contentsDecoded[$key] = $value;
        }

        // encode the array back into a JSON string.
        $jsonContent = json_encode($contentsDecoded, JSON_THROW_ON_ERROR);

        // this is what the apidoc.json file will point to, to load the header.md
        // write the actual file
        $this->fileForceContents($this->outputPath, $jsonContent);

        return $this->outputPath;
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
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $dir));
            }
        }
        file_put_contents("{$dir}/{$file}", $contents);
    }
}
