<?php

namespace Routing;

use Http\Request;
use Http\Response;

/**
 * Site endpoint.
 */
interface Endpoint
{

    /**
     * Returns HTTP response.
     *
     * @param Request $request
     * @return Response
     */
    public function response(Request $request): Response;
}
