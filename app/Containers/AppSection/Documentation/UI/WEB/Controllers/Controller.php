<?php

namespace App\Containers\AppSection\Documentation\UI\WEB\Controllers;

use Apiato\Core\Abstracts\Controllers\WebController as AbstractWebController;
use App\Containers\AppSection\Documentation\UI\WEB\Requests\GetPrivateDocumentationRequest;
use App\Containers\AppSection\Documentation\UI\WEB\Requests\GetPublicDocumentationRequest;

class Controller extends AbstractWebController
{
    public function showPrivateDocs(GetPrivateDocumentationRequest $request)
    {
        return view('vendor@documentation::documentation.private.index');
    }

    public function showPublicDocs(GetPublicDocumentationRequest $request)
    {
        return view('vendor@documentation::documentation.public.index');
    }
}
