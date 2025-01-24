<?php

namespace App\Ship\Parents\Collections;

use Apiato\Abstract\Collections\EloquentCollection as AbstractEloquentCollection;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TKey of array-key
 * @template TModel of Model
 *
 * @extends AbstractEloquentCollection<TKey, TModel>
 */
abstract class EloquentCollection extends AbstractEloquentCollection
{
}
