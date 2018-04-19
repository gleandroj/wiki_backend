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

class CustomerWebController extends Controller
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
        $customers = $this->customerService->paginate(request()->get('perPage', 5));
        return view('customers.index', compact('customers'));
    }

    /**
     * 
     */
    public function show(Customer $customer){
        $title = 'Visualizar';
        $disabled = true;
        return view('customers.form', compact('customer', 'title', 'disabled'));
    }

    /**
     * 
     */
    public function edit(Customer $customer){
        $title = 'Editar';
        $disabled = false;
        return view('customers.form', compact('customer', 'title', 'disabled'));
    }


    /**
     * 
     */
    public function create(){
        $title = 'Cadastrar';
        $disabled = false;
        return view('customers.form', compact('title', 'disabled'));
    }

    /**
     * 
     */
    public function store(StoreCustomerRequest $request){
        $this->customerSerivce->create($request->all());
        return redirect()->back();
    }

    /**
     * 
     */
    public function update(Customer $customer, UpdateCustomerRequest $request){
        $this->customerSerivce->update($customer->id, $request->all());
        return redirect()->back();
    }

    /**
     * 
     */
    public function destroy(Customer $customer, Request $request){
        $this->customerService->delete($customer->id);
        return redirect()->back();
    }
}
