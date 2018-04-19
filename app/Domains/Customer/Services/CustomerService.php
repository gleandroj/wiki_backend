<?php

namespace Wiki\Domains\Customer\Services;

use Wiki\Domains\Customer\Models\Customer;
use Wiki\Domains\Customer\Repositories\CustomerRepository;
use Wiki\Domains\Customer\Contracts\CustomerServiceContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;

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
     * @return Collection|Customer
     */
    public function paginate($perPage = 10)
    {
        return $this->customerRepository->paginate($perPage);
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
        $data->put('dt_nascimento', Carbon::createFromFormat('d/m/Y', $data->get('dt_nascimento')));
        if(!$customer = $this->customerRepository->create($data->all()))
            throw new \Exception(trans('messages.MSG4'));

        return $customer->fresh();
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
        $data->put('dt_nascimento', Carbon::createFromFormat('d/m/Y', $data->get('dt_nascimento')));
        $oldCustomer = $this->getById($id);

        if(!$customer = $this->customerRepository->update($id, $data->all()))
            throw new \Exception(trans('messages.MSG4'));

        return $customer->fresh();
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function delete($id)
    {
        if(!$deleted = $this->customerRepository->delete($id)) throw new \Exception(trans('messages.MSG4'));
        return $deleted->fresh();
    }

    /**
     * @param $id
     * @return Customer|\Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function restore($id)
    {
        if(!$restored = $this->customerRepository->restore($id)) throw new \Exception(trans('messages.MSG4'));
        return $restored->fresh();
    }
}