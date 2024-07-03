<?php

namespace App\Containers\AppSection\Authentication\Tasks;

use App\Containers\AppSection\Authentication\Exceptions\LoginFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use GuzzleHttp\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CallOAuthServerTask extends ParentTask
{
    /**
     * @throws LoginFailedException
     */
    public function run(array $data, ?string $languageHeader = null): float|object|int|bool|array|string|null
    {
        $authFullApiUrl = route('passport.token');

        $headers = [
            'HTTP_ACCEPT' => 'application/json',
            'HTTP_ACCEPT_LANGUAGE' => $languageHeader ?? config('app.locale'),
        ];

        $request = Request::create($authFullApiUrl, 'POST', $data, server: $headers);
        $response = App::handle($request);
        $content = Utils::jsonDecode($response->getContent(), true);

        if (!$response->isOk()) {
            throw new LoginFailedException($content['message'] ?? null);
        }

        return $content;
    }
}
