<?php

namespace Sync\Pipedrive\Guzzle;

use GuzzleHttp\Client;
use Sync\Pipedrive\Request as RequestInterface;

class Request implements RequestInterface
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Make a request and retrieve the json response
     *
     * @param $endpoint
     * @param array $params
     *
     * @return array
     * @throws \Exception
     */
    public function get($endpoint, $params = [])
    {
        $result = $this->client
            ->get($this->buildEndpoint($endpoint, $params));

        if ($result->getStatusCode() != 200) {
            /**
             * @todo create an new exception
             */
            throw new \Exception('Error during the request...');
        }

        $result = json_decode($result->getBody(), true);

        if (! $result['success']) {
            return [];
        }

        return $result['data'];
    }

    /**
     * Build the url to the pipedrive api
     *
     * @param $endpoint
     * @param array $params
     *
     * @return string
     */
    protected function buildEndpoint($endpoint, $params = [])
    {
        if (! array_key_exists('api_token', $params)) {
            $params['api_token'] = getenv('PIPEDRIVE_API_TOKEN');
        }

        return getenv('PIPEDRIVE_URL') . $endpoint . '/' . http_build_query($params);
    }
}