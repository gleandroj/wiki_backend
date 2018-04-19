<?php

namespace Wiki\Units\Customer\Http\Controllers;

use Wiki\Domains\Customer\Models\Customer;
use Wiki\Domains\Customer\Contracts\CustomerServiceContract;
use Wiki\Support\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class CustomerController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Customer|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nome' => 'required|string',
            'dt_nascimento' => 'required|date_format:Y-m-d',
            'rg' => 'required|unique:customers,rg|integer',
            'cpf' => 'required|unique:customers,cpf|string|regex:/[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}/',
            'telefone' => 'required|string|regex:/\([0-9]{2}\) ([0-9]{4,5}-[0-9]{4})/'
        ]);

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
        return $this->customerService->getById($customer->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Customer $customer
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(Request $request, Customer $customer)
    {
        $this->validate($request, [
            
        ]);
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
