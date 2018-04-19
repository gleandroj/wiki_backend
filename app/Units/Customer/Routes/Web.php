<?php

namespace Wiki\Units\Customer\Routes;

use Wiki\Support\Http\Routing\RouteFile;

class Web extends RouteFile
{
    /**
     * Define routes.
     *
     * @return mixed
     */
    public function routes()
    {
        $this->router->get('/', function(){
            return redirect('customers');
        });
        $this->router->resource('/customers', 'Controllers\CustomerWebController');
    }
}