<?php

namespace App\Ship\Parents\Repositories;

use Apiato\Abstract\Repositories\Repository as AbstractRepository;
use App\Ship\Exceptions\ResourceNotFound;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * @template TModel of Model
 */
abstract class Repository extends AbstractRepository
{
    /**
     * Find a model by its primary key.
     *
     * @return TModel|null
     */
    public function findById(int|string $id, array $columns = ['*'])
    {
        try {
            return $this->find($id, $columns);
        } catch (ModelNotFoundException) {
            return null;
        }
    }

    /**
     * Get a model by its primary key or throw an exception.
     *
     * @return TModel
     *
     * @throws ModelNotFoundException
     */
    public function getById(int|string $id, array $columns = ['*'])
    {
        return $this->find($id, $columns);
    }

    /**
     * @return Collection<array-key, TModel>
     */
    public function findMany(array|Arrayable $ids, array $columns = ['*']): Collection
    {
        try {
            return $this->find($ids, $columns);
        } catch (ModelNotFoundException) {
            return new Collection();
        }
    }

    /**
     * Delete a model by its primary key or throw an exception.
     *
     * @param int|string $id
     *
     * @throws ResourceNotFound
     */
    public function delete($id): bool
    {
        try {
            return (bool) parent::delete($id);
        } catch (ModelNotFoundException) {
            throw ResourceNotFound::create();
        }
    }

    /**
     * @param class-string<CriteriaInterface> $criteria Criteria class name
     * @param array<string, mixed> $args Arguments to pass to the criteria constructor
     *
     * @throws RepositoryException
     * @throws BindingResolutionException
     */
    public function pushCriteriaWith(string $criteria, array $args): static
    {
        /** @var CriteriaInterface $criteriaInstance */
        $criteriaInstance = $this->app->makeWith($criteria, $args);

        return $this->pushCriteria($criteriaInstance);
    }
}
