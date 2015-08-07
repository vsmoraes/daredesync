<?php

namespace Sync\Pipedrive;


interface Request
{
    /**
     * Make a request and retrieve the json response
     *
     * @param $endpoint
     * @param array $params
     *
     * @return array
     * @throws \Exception
     */
    public function get($endpoint, $params = []);
}
