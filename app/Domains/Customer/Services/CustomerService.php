<?php

namespace Wiki\Domains\Customer\Services;

use Wiki\Domains\Customer\Models\Customer;
use Wiki\Domains\Customer\Repositories\CustomerRepository;
use Wiki\Domains\Customer\Contracts\CustomerServiceContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CustomerService implements CustomerServiceContract
{
    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * CustomerService constructor.
     * @param CustomerRepository $customerRepository
     */
    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @return Collection|Customer
     */
    public function getAll()
    {
        return $this->customerRepository->getAll();
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @param $id
     * @return Customer|\Illuminate\Database\Eloquent\Model
     */
    public function getById($id)
    {
        if(!$customer = $this->customerRepository->getById($id)) throw (new ModelNotFoundException())->setModel(Customer::class);
        return $customer;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function create(array $data)
    {
        $data = collect($data);

        if(!$customer = $this->customerRepository->create($data->all()))
            throw new \Exception(trans('messages.MSG4'));

        return $customer;
    }

    /**
     * @param $id
     * @param array $data
     * @return Customer|\Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function update($id, array $data)
    {
        $data = collect($data);
        $oldCustomer = $this->getById($id);

        if(!$customer = $this->customerRepository->update($id, $data->all()))
            throw new \Exception(trans('messages.MSG4'));

        return $customer;
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function delete($id)
    {
        if(!$deleted = $this->customerRepository->delete($id)) throw new \Exception(trans('messages.MSG4'));
        return $deleted;
    }

    /**
     * @param $id
     * @return Customer|\Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function restore($id)
    {
        if(!$restored = $this->customerRepository->restore($id)) throw new \Exception(trans('messages.MSG4'));
        return $restored;
    }
}