<?php

namespace Wiki\Domains\Customer\Contracts;

use Wiki\Domains\Customer\Models\Customer;

interface CustomerServiceContract
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|Customer
     */
    public function getAll();

    /**
     * The attributes that should be hidden for arrays.
     *
     * @param $id
     * @return Customer
     */
    public function getById($id);

    /**
     * @param array $data
     * @return Customer
     */
    public function create(array $data);

    /**
     * @param $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data);

    /**
     * @param $id
     * @return Customer
     * @throws \Exception
     */
    public function delete($id);

    /**
     * @param $id
     * @return Customer
     * @throws \Exception
     */
    public function restore($id);
}