<?php

namespace Wiki\Infrastructure\Data\Repositories;

use Wiki\Support\Repositories\RepositoryContract;
use Wiki\Support\Repositories\UnitOfWorkContract;
use Illuminate\Database\Eloquent\Model;

class AbstractRepository implements RepositoryContract
{
    /**
     * AbstractRepository constructor.
     * @param User $model
     * @param UnitOfWorkContract $uow
     */
    public function __construct(Model $model, UnitOfWorkContract $uow)
    {
    }
}