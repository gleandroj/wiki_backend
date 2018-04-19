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
        
        $this->router->pattern('customer', '[0-9]+');
        $this->router->group(['middleware' => ['api']], function () {
            $this->router->get('/customers/{customer}/restore', 'Controllers\CustomerApiController@restore');
            $this->router->get('/customers/paginate', 'Controllers\CustomerApiController@paginate');
            $this->router->resource('/customers', 'Controllers\CustomerApiController', ['except' => ['create', 'edit']]);
        });
    }
}