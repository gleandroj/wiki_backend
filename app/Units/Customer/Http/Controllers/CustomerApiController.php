<?php

namespace Wiki\Units\Customer\Http\Controllers;

use Wiki\Domains\Customer\Models\Customer;
use Wiki\Domains\Customer\Contracts\CustomerServiceContract;
use Wiki\Support\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Wiki\Units\Customer\Http\Requests\StoreCustomerRequest;
use Wiki\Units\Customer\Http\Requests\UpdateCustomerRequest;

class CustomerApiController extends Controller
{
    /**
     * @var CustomerServiceContract
     */
    private $customerService;

    /**
     * CustomerController constructor.
     * @param CustomerServiceContract $customerService
     */
    public function __construct(CustomerServiceContract $customerService)
    {
        $this->customerService = $customerService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Customer|Collection|\Illuminate\Http\Response
     */
    public function index()
    {
        return $this->customerService->getAll();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Customer|Collection|\Illuminate\Http\Response
     */
    public function paginate()
    {
        return $this->customerService->paginate(request()->get('perPage', 10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Customer|\Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {
        return response()->json($this->customerService->create($request->all())->toArray(), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Customer $customer
     * @return Customer|\Illuminate\Http\Response
     * @internal param int $id
     */
    public function show(Customer $customer)
    {
        return $customer;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Customer $customer
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        return $this->customerService->update($customer->id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Customer $customer
     * @return Customer|\Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        return $this->customerService->delete($customer->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Customer $customer
     * @return Customer|Response
     * @internal param $id
     */
    public function restore(Customer $customer)
    {
        return $this->customerService->restore($customer->id);
    }
}
