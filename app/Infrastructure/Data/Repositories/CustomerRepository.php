<?php

namespace Wiki\Infrastructure\Data\Repositories;

use Wiki\Domains\Customer\Models\Customer;
use Wiki\Support\Repositories\UnitOfWorkContract;
use Wiki\Domains\Customer\Repositories\CustomerRepository as CustomerRepositoryInterface;

class CustomerRepository extends AbstractRepository implements CustomerRepositoryInterface
{
    /**
     * CustomerRepository constructor.
     * @param Customer $model
     * @param UnitOfWorkContract $uow
     */
    public function __construct(Customer $model, UnitOfWorkContract $uow)
    {
        parent::__construct($model, $uow);
    }

    /**
     * Paginate
     */
    public function paginate($perPage = 10){
        return $this->model->orderBy('created_at', 'DESC')->orderBy('id', 'DESC')->paginate($perPage);
    }
}