<?php

namespace App\Containers\AppSection\User\Tests\Unit\Values;

use App\Containers\AppSection\User\Data\Factories\UserFactory;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use App\Containers\AppSection\User\Values\Email;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;

#[Group('user')]
#[CoversClass(Email::class)]
final class EmailTest extends UnitTestCase
{
    public static function emailDataProvider(): array
    {
        $email = 'duPliCate@eXampLe.cOm';

        return [
            'sameCasing' => compact('email'),
            'differentCasingLower' => ['email' => Str::lower($email)],
            'differentCasingUpper' => ['email' => Str::upper($email)],
        ];
    }

    public function testEmailIsValid(): void
    {
        $email = new Email('test@example.com');

        $email->validate();

        $this->assertTrue(true);
    }

    public function testEmailIsInvalid(): void
    {
        $this->expectException(ValidationException::class);

        $email = new Email('invalid-email');

        $email->validate();
    }

    public function testAllowsUsingUniqueCaseInsensitiveEmail(): void
    {
        $email = new Email('unique@example.com');
        UserFactory::new()->createOne(['email' => 'different@example.com']);

        $email->validate();

        $this->assertTrue(true);
    }

    #[DataProvider('emailDataProvider')]
    public function testCanDetectNonUniqueCaseInsensitiveEmail($email): void
    {
        $this->expectException(ValidationException::class);

        UserFactory::new()->createOne(['email' => 'duPliCate@eXampLe.cOm']);
        $email = new Email($email);

        $email->validate();
    }

    public function testEmailToString(): void
    {
        $email = new Email('test@example.com');
        $this->assertEquals('test@example.com', (string) $email);
    }

    public function testEmailEquality(): void
    {
        $email1 = new Email('test@example.com');
        $email2 = new Email('test@example.com');
        $email3 = new Email('different@example.com');

        $this->assertTrue($email1->equals($email2));
        $this->assertFalse($email1->equals($email3));
    }
}
