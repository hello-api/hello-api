<?php

namespace App\Containers\AppSection\Documentation\UI\WEB\Controllers;

use Apiato\Core\Abstracts\Controllers\WebController as AbstractWebController;
use App\Containers\AppSection\Documentation\UI\WEB\Requests\GetPrivateDocumentationRequest;
use App\Containers\AppSection\Documentation\UI\WEB\Requests\GetPublicDocumentationRequest;

class Controller extends AbstractWebController
{
    public function showPrivateDocs(GetPrivateDocumentationRequest $request)
    {
        return view('appSection@documentation::swagger.index', [
            'urls' => [
                [
                    'name' => 'Private',
                    'url' => config('apiato.api.url') . '/assets/documentation/json/openapi.private.json',
                ],
                [
                    'name' => 'Public',
                    'url' => config('apiato.api.url') . '/assets/documentation/json/openapi.public.json',
                ],
            ],
        ]);
    }

    public function showPublicDocs(GetPublicDocumentationRequest $request)
    {
        return view('appSection@documentation::swagger.index', [
            'urls' => [
                [
                    'name' => 'Public',
                    'url' => config('apiato.api.url') . '/assets/documentation/json/openapi.public.json',
                ],
            ],
        ]);
    }
}
