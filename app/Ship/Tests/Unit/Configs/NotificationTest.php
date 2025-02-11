<?php

namespace App\Ship\Tests\Unit\Configs;

use App\Ship\Tests\ShipTestCase;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class NotificationTest extends ShipTestCase
{
    public function testConfigHasCorrectValues(): void
    {
        $config = config('notification');
        $expected = [
            'channels' => [
                'database',
                // 'mail',
            ],
        ];

        $this->assertEqualsCanonicalizing($expected, $config);
    }
}
