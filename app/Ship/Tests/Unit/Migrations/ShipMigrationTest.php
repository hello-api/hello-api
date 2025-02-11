<?php

namespace App\Ship\Tests\Unit\Migrations;

use App\Ship\Tests\ShipTestCase;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class ShipMigrationTest extends ShipTestCase
{
    public function testCacheTableHasExpectedColumns(): void
    {
        $columns = [
            'key' => 'varchar',
            'value' => 'text',
            'expiration' => 'int4',
        ];

        $this->assertDatabaseTable('cache', $columns);
    }

    public function testCacheLocksTableHasExpectedColumns(): void
    {
        $columns = [
            'key' => 'varchar',
            'owner' => 'varchar',
            'expiration' => 'int4',
        ];

        $this->assertDatabaseTable('cache_locks', $columns);
    }

    public function testJobsTableHasExpectedColumns(): void
    {
        $columns = [
            'id' => 'int8',
            'queue' => 'varchar',
            'payload' => 'text',
            'attempts' => 'int2',
            'reserved_at' => 'int4',
            'available_at' => 'int4',
            'created_at' => 'int4',
        ];

        $this->assertDatabaseTable('jobs', $columns);
    }

    public function testJobBatchesTableHasExpectedColumns(): void
    {
        $columns = [
            'id' => 'varchar',
            'name' => 'varchar',
            'total_jobs' => 'int4',
            'pending_jobs' => 'int4',
            'failed_jobs' => 'int4',
            'failed_job_ids' => 'text',
            'options' => 'text',
            'cancelled_at' => 'int4',
            'created_at' => 'int4',
            'finished_at' => 'int4',
        ];

        $this->assertDatabaseTable('job_batches', $columns);
    }

    public function testFailedJobsTableHasExpectedColumns(): void
    {
        $columns = [
            'id' => 'int8',
            'connection' => 'text',
            'queue' => 'text',
            'payload' => 'text',
            'exception' => 'text',
            'failed_at' => 'timestamp',
            'uuid' => 'varchar',
        ];

        $this->assertDatabaseTable('failed_jobs', $columns);
    }

    public function testNotificationsTableHasExpectedColumns(): void
    {
        $columns = [
            'id' => 'uuid',
            'type' => 'varchar',
            'notifiable_id' => 'int8',
            'notifiable_type' => 'varchar',
            'data' => 'text',
            'read_at' => 'timestamp',
            'created_at' => 'timestamp',
            'updated_at' => 'timestamp',
        ];

        $this->assertDatabaseTable('notifications', $columns);
    }
}
