<?php

namespace App\Containers\AppSection\Authentication\Tests\Functional\API;

use App\Containers\AppSection\Authentication\Tests\Functional\ApiTestCase;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class LogoutTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/logout';

    public function testLogout(): void
    {
        $response = $this->makeCall([], [
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImUxODk3NjU3YTVlZWQxMDkyMThlZjVmOThlMGMzMzg5OTQ3MzNkZDYyZWM0Nzk5Y2E0NWQ1NjUyYmQ0NjFiZWUzZWQ5YjU1ZjNmMGE2NTA3In0.eyJhdWQiOiIyIiwianRpIjoiZTE4OTc2NTdhNWVlZDEwOTIxOGVmNWY5OGUwYzMzODk5NDczM2RkNjJlYzQ3OTljYTQ1ZDU2NTJiZDQ2MWJlZTNlZDliNTVmM2YwYTY1MDciLCJpYXQiOjE1MTI4NzgzNjMsIm5iZiI6MTUxMjg3ODM2MywiZXhwIjoxODI4MjM4MzYyLCJzdWIiOiI0Iiwic2NvcGVzIjpbXX0.q1MXp5odmhlurbGa-Ft8m3U3DA6CetCCk23ap8aqY2z_pTpfugqh6vqCe-8iVE9cJPjoMifWAFQ4UeTy_Y0PRurRh7o8_jCqclQ-1IudPmggayyS0kBYoHRRHT-2wzdpIw7jDLg589HV2HClbBq5IwYvLw3yqRTGmEgTFEJ2jCnT58A2sAuRuJ95k3FjuyBZ33dvoFelotMOSG0wR-2H7JjWRi4SL0XEZikoIlT4aAFC8Xa8TVt8ZsfQxDjc9Uyg6HBGTQo5JZNZgSje_0K4DyrHzW3tbWJ2CxLQjTPpWyEcVGavZ55UEjGJXr4JmFAZMCEyIfq0xop1ZnIOiIrmI1ajopXwcTTo0K8ymDDCAgB8JbGQTcGGSZe2VHJCXXaQJvesIlvke6ZvsoKwUqphpe99Qi67e3TA0_uDK8_u-Bv4lew95lg3IXBMKvfXvi17rEDvO23uClDWnZUhHKgqtPhO8oG7A1hFR8arLN1lEKrP44zO5470cD6_Pw7Ngi1coJeG5jXmtRb9gCpksdYQBB5csURioYSZuHNZQBGVWZVzlURPWvgtSd_aL646KmMmy64L4MA1QXsqXzzuLULGbcSntB8N-2XcogdTFe0ZG6RL8UzcArZx0Xur8CCi01UuPkBCnv5R4hxIjsQDkmFIDmrCyo2VuoVyrlxWIgsTm04',
        ]);

        $response->assertAccepted();

        $response->assertJson(
            static fn (AssertableJson $json): AssertableJson => $json
                ->where('message', 'Token revoked successfully.'),
        );
    }

    public function testLogoutWhileUnauthenticated(): void
    {
        $this->testingUser = User::factory()->createOne();

        $response = $this->auth(false)->makeCall();

        $response->assertUnauthorized();
    }
}
