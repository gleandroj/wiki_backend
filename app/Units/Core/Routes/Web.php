<?php

namespace Wiki\Units\Core\Routes;

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
        $this->router->get('/', function () {
            return view('app');
        });
    }
}