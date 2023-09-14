<?php

namespace App\Containers\AppSection\Documentation\Traits;

trait DocsGeneratorTrait
{
    private function getFullDocsUrl(string $type): string
    {
        return '> ' . $this->getAppUrl() . '/' . $this->getUrl($type);
    }

    private function getAppUrl(): string
    {
        return config('app.url');
    }

    private function getUrl(string $type): string
    {
        return $this->getTypeConfigs()[$type]['url'];
    }

    private function getTypeConfigs(): array
    {
        return config($this->getConfigFile() . '.types');
    }

    private function getConfigFile(): string
    {
        return 'documentation';
    }

    private function getDocumentationPath(string $type): string
    {
        return $this->getHtmlPath() . $this->getFolderName($type);
    }

    private function getHtmlPath(): string
    {
        return config("{$this->getConfigFile()}.html_files");
    }

    private function getFolderName(string $type): string
    {
        return $this->getTypeConfigs()[$type]['folder-name'];
    }

    private function getJsonFilePath(string $type): string
    {
        return $this->getApiDocJsConfigsPath() . '/' . $this->getJsonFileName($type);
    }

    private function getApiDocJsConfigsPath(): string
    {
        return $this->getPathInDocumentationContainer('/ApiDocJs/Configs');
    }

    private function getPathInDocumentationContainer(string $path): string
    {
        return app_path('Containers/' . config('documentation.section_name') . '/Documentation' . $path);
    }

    private function getJsonFileName(string $type): string
    {
        return 'apidoc.' . $type . '.json';
    }

    private function getExecutable(): string
    {
        return config($this->getConfigFile() . '.executable');
    }

    private function getEndpointFiles(string $type): array
    {
        $routeFilesCommand = [];
        $routes = $this->getTypeConfigs()[$type]['routes'];

        foreach ($routes as $route) {
            $routeFilesCommand[] = '-f';
            $routeFilesCommand[] = $route . '.php';
        }

        return $routeFilesCommand;
    }
}
