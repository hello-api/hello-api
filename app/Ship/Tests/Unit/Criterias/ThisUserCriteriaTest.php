<?php

namespace App\Ship\Tests\Unit\Criterias;

use App\Ship\Criterias\ThisUserCriteria;
use App\Ship\Tests\Fakes\TestUserFactory;
use App\Ship\Tests\Fakes\TestUserRepository;
use App\Ship\Tests\ShipTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ThisUserCriteria::class)]
final class ThisUserCriteriaTest extends ShipTestCase
{
    public function testCriteria(): void
    {
        TestUserFactory::new()->create(['user_id' => 2]);
        $model = TestUserFactory::new()->create(['user_id' => 1]);
        TestUserFactory::new()->create(['user_id' => 3]);

        $repository = app(TestUserRepository::class);
        $criteria = new ThisUserCriteria(1);
        $repository->pushCriteria($criteria);

        $result = $repository->all();

        $this->assertSame(1, $result->count());
        $this->assertSame($model->id, $result->first()->id);
    }
}
