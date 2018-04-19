<?php

namespace Wiki\Units\Core\Routes;

use Wiki\Support\Http\Routing\RouteFile;

class Testing extends RouteFile
{
    /**
     * Define routes.
     *
     * @return mixed
     */
    public function routes()
    {
        $this->router->get('ping', function () {
            return 'pong';
        });
    }
}