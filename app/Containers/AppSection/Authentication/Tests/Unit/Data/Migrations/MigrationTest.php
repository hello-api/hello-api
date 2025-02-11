<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\Data\Migrations;

use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class MigrationTest extends UnitTestCase
{
    public function testOAuthAuthCodesTableHasExpectedColumns(): void
    {
        $columns = [
            'id' => 'varchar',
            'user_id' => 'int8',
            'client_id' => 'int8',
            'scopes' => 'text',
            'revoked' => 'bool',
            'expires_at' => 'timestamp',
        ];

        $this->assertDatabaseTable('oauth_auth_codes', $columns);
    }

    public function testOAuthAccessTokenTableHasExpectedColumns(): void
    {
        $columns = [
            'id' => 'varchar',
            'user_id' => 'int8',
            'client_id' => 'int8',
            'name' => 'varchar',
            'scopes' => 'text',
            'revoked' => 'bool',
            'created_at' => 'timestamp',
            'updated_at' => 'timestamp',
            'expires_at' => 'timestamp',
        ];

        $this->assertDatabaseTable('oauth_access_tokens', $columns);
    }

    public function testOAuthRefreshTokenTableHasExpectedColumns(): void
    {
        $columns = [
            'id' => 'varchar',
            'access_token_id' => 'varchar',
            'revoked' => 'bool',
            'expires_at' => 'timestamp',
        ];

        $this->assertDatabaseTable('oauth_refresh_tokens', $columns);
    }

    public function testOAuthClientsTableHasExpectedColumns(): void
    {
        $columns = [
            'id' => 'int8',
            'user_id' => 'int8',
            'name' => 'varchar',
            'secret' => 'varchar',
            'provider' => 'varchar',
            'redirect' => 'text',
            'personal_access_client' => 'bool',
            'password_client' => 'bool',
            'revoked' => 'bool',
            'created_at' => 'timestamp',
            'updated_at' => 'timestamp',
        ];

        $this->assertDatabaseTable('oauth_clients', $columns);
    }

    public function testOAuthPersonamAccessClientsTableHasExpectedColumns(): void
    {
        $columns = [
            'id' => 'int8',
            'client_id' => 'int8',
            'created_at' => 'timestamp',
            'updated_at' => 'timestamp',
        ];

        $this->assertDatabaseTable('oauth_personal_access_clients', $columns);
    }
}
