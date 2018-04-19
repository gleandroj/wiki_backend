<?php

namespace Wiki\Units\Customer\Routes;

use Wiki\Support\Http\Routing\RouteFile;

class Api extends RouteFile
{
    /**
     * Define routes.
     *
     * @return mixed
     */
    public function routes()
    {
        $this->router->group(['middleware' => ['api']], function () {
            $this->router->get('/customers/{customer}/restore', 'Controllers\CustomerController@restore');
            $this->router->resource('/customers', 'Controllers\CustomerController', ['except' => ['create', 'edit']]);
        });
    }
}