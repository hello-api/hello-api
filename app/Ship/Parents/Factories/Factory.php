<?php

namespace App\Ship\Parents\Factories;

use Apiato\Abstract\Factories\Factory as AbstractFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of Model
 *
 * @extends AbstractFactory<TModel>
 */
abstract class Factory extends AbstractFactory
{
}
