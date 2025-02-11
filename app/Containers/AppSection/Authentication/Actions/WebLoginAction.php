<?php

namespace App\Containers\AppSection\Authentication\Actions;

use App\Containers\AppSection\Authentication\Classes\LoginFieldParser;
use App\Containers\AppSection\Authentication\DataTransferObjects\IncomingLoginField;
use App\Containers\AppSection\Authentication\UI\WEB\Requests\LoginRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class WebLoginAction extends ParentAction
{
    public function run(LoginRequest $request): RedirectResponse
    {
        $sanitizedData = $request->sanitize([
            ...array_keys(config('appSection-authentication.login.fields', ['email' => []])),
            'password',
            'remember' => false,
        ]);

        $loginFields = LoginFieldParser::extractAll($sanitizedData);
        $credentials = [];
        foreach ($loginFields as $loginField) {
            $credentials[$loginField->name] =
                static fn (Builder $query): Builder => $query
                    ->orWhereRaw("lower({$loginField->name}) = lower(?)", [$loginField->value]);
        }
        $credentials['password'] = $sanitizedData['password'];

        $loggedIn = Auth::guard('web')->attempt($credentials, $sanitizedData['remember']);

        // TODO: This doesnt feels right. Maybe we should move this to controller?
        // You know, the controller should be the one who decides where to redirect the user.
        if ($loggedIn) {
            session()->regenerate();

            return redirect()->intended();
        }

        $errorResult = array_reduce(
            $loginFields,
            static fn (array $result, IncomingLoginField $loginField): array => [
                'errors' => array_merge($result['errors'], [$loginField->name => __('auth.failed')]),
                'fields' => array_merge($result['fields'], [$loginField->name]),
            ],
            ['errors' => [], 'fields' => []],
        );

        return back()->withErrors(
            $errorResult['errors'],
        )->onlyInput(...$errorResult['fields']);
    }
}
