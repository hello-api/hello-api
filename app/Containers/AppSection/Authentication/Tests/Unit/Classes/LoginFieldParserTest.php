<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\Classes;

use App\Containers\AppSection\Authentication\Classes\LoginFieldParser;
use App\Containers\AppSection\Authentication\DataTransferObjects\IncomingLoginField;
use App\Containers\AppSection\Authentication\DataTransferObjects\LoginField;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(LoginFieldParser::class)]
final class LoginFieldParserTest extends UnitTestCase
{
    public static function loginDataProvider(): array
    {
        $email = 'gandalf@the.grey';
        $name = 'gandalf';
        $extractedEmailField = new IncomingLoginField('email', 'gandalf@the.grey');
        $extractedNameField = new IncomingLoginField('name', 'gandalf');

        return [
            [
                'input' => compact('email'),
                'expected' => [$extractedEmailField],
            ],
            [
                'input' => compact('name'),
                'expected' => [$extractedNameField],
            ],
            [
                'input' => compact('email', 'name'),
                'expected' => [$extractedEmailField, $extractedNameField],
            ],
            [
                'input' => compact('name', 'email'),
                // input order should not matter,
                // results are returned in the order they are defined in the config file.
                'expected' => [$extractedEmailField, $extractedNameField],
            ],
        ];
    }

    #[DataProvider('loginDataProvider')]
    public function testCanExtractUsernameFromValidInput(array $input, array $expected): void
    {
        config()->set('appSection-authentication.login.fields', ['email' => [], 'name' => []]);

        $result = LoginFieldParser::extractAll($input);

        $this->assertEquals($result, $expected);
    }

    public function testShouldDiscardUnknownFields(): void
    {
        $credentials = [
            'email' => 'gandalf@the.grey',
            'password' => 'youShallNotPass, should be discarded',
            'unknown' => 'field, should be discarded',
        ];
        $expected = [new IncomingLoginField('email', 'gandalf@the.grey')];

        $result = LoginFieldParser::extractAll($credentials);

        $this->assertEquals($result, $expected);
    }

    public function testUsesEmailFieldAsDefaultFallback(): void
    {
        config()->unset('appSection-authentication.login.fields');
        $credentials = [
            'email' => 'gandalf@the.grey',
            'password' => 'youShallNotPass',
        ];
        $expected = [new IncomingLoginField('email', 'gandalf@the.grey')];

        $result = LoginFieldParser::extractAll($credentials);

        $this->assertEquals($result, $expected);
    }

    public function testEmptyCredentialsThrowsException(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('No matching login field found');

        LoginFieldParser::extractAll([]);
    }

    public static function invalidLoginFieldsDataProvider(): array
    {
        return [
            [
                'ThisIsNotArray!',
                \InvalidArgumentException::class,
                'Login {fields} property must be an array, string given',
            ],
            [
                [(int) 'ThisIsNotString!'],
                \InvalidArgumentException::class,
                'Login fields keys must be a string, integer given',
            ],
        ];
    }

    #[DataProvider('invalidLoginFieldsDataProvider')]
    public function testInvalidLoginFields(mixed $invalidFields, string $exceptedException, string $exceptedMessage): void
    {
        $this->expectException($exceptedException);
        $this->expectExceptionMessage($exceptedMessage);

        config()->set('appSection-authentication.login.fields', $invalidFields);
        $userDetails = [
            'email' => 'gandalf@the.grey',
            'password' => 'youShallNotPass',
        ];

        LoginFieldParser::extractAll($userDetails);
    }

    public function testMergeValidationRulesWithException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The login fields must be an array');

        config()->set('appSection-authentication.login.fields', 'ThisIsNotArray!');
        $newRules = [
            'password' => 'required',
            'remember' => 'boolean',
        ];

        LoginFieldParser::mergeValidationRules($newRules);
    }

    public static function multiLoginFieldProvider(): array
    {
        return [
            [
                [
                    new LoginField('email', ['required|email']),
                    'required_without_all:name,city|email',
                ],
                [
                    new LoginField('name', ['string', 'max:255']),
                    'required_without_all:email,city|string|max:255',
                ],
                [
                    new LoginField('city', ['required|string', 'min:3']),
                    'required_without_all:email,name|string|min:3',
                ],
            ],
            [
                [
                    new LoginField('email', ['email']),
                    'required_without_all:name,city|email',
                ],
                [
                    new LoginField('name', []),
                    'required_without_all:email,city',
                ],
                [
                    new LoginField('city', ['required']),
                    'required_without_all:email,name',
                ],
            ],
            [
                [
                    new LoginField('email', ['email|nullable', 'max:255|nullable']),
                    'required_without_all:name,city|email|nullable|max:255',
                ],
                [
                    new LoginField('name', ['string', 'required']),
                    'required_without_all:email,city|string',
                ],
                [
                    new LoginField('city', ['required|string|string', 'min:3|string']),
                    'required_without_all:email,name|string|min:3',
                ],
            ],
        ];
    }

    /**
     * @param array{LoginField, string} $email
     * @param array{LoginField, string} $name
     * @param array{LoginField, string} $city
     */
    #[DataProvider('multiLoginFieldProvider')]
    public function testCanMergeValidationRules(array $email, array $name, array $city): void
    {
        [$emailField, $emailExpectedRule] = $email;
        [$nameField, $nameExpectedRule] = $name;
        [$cityField, $cityExpectedRule] = $city;
        Config::set('appSection-authentication.login.fields', [
            ...$emailField->toArray(),
            ...$nameField->toArray(),
            ...$cityField->toArray(),
        ]);
        $rules = [
            'phone' => ['required', 'numeric'],
            'address' => ['string'],
            'age' => ['nullable', 'integer'],
        ];

        $result = LoginFieldParser::mergeValidationRules($rules);

        $this->assertSame([
            'phone' => ['required', 'numeric'],
            'address' => ['string'],
            'age' => ['nullable', 'integer'],
            $emailField->name() => $emailExpectedRule,
            $nameField->name() => $nameExpectedRule,
            $cityField->name() => $cityExpectedRule,
        ], $result);
    }

    public static function singleLoginFieldProvider(): array
    {
        return [
            [
                new LoginField('city', ['required|string', 'min:3']),
                'expectation' => 'required|string|min:3',
            ],
            [
                new LoginField('city', []),
                'expectation' => 'required',
            ],
            [
                new LoginField('city', ['required|string|required|string', 'min:3']),
                'expectation' => 'required|string|min:3',
            ],
            [
                new LoginField('city', ['string', 'min:4', 'required', 'string']),
                'expectation' => 'string|min:4|required',
            ],
            [
                new LoginField('city', ['min:3|string']),
                'expectation' => 'required|min:3|string',
            ],
            [
                new LoginField('city', ['string', 'required', 'min:3']),
                'expectation' => 'string|required|min:3',
            ],
        ];
    }

    #[DataProvider('singleLoginFieldProvider')]
    public function testGivenOnlyOneFieldExistsShouldNotAddMultiLoginRelatedRule(LoginField $field, string $expectation): void
    {
        Config::set('appSection-authentication.login.fields', [$field->name() => $field->rules()]);
        $rules = [
            'phone' => ['required', 'numeric'],
            'address' => ['string'],
            'age' => ['nullable', 'integer'],
        ];

        $result = LoginFieldParser::mergeValidationRules($rules);

        $this->assertSame([
            'phone' => ['required', 'numeric'],
            'address' => ['string'],
            'age' => ['nullable', 'integer'],
            $field->name() => $expectation,
        ], $result);
    }
}
