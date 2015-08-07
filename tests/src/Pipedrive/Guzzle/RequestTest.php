<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Sync\Pipedrive\Guzzle\Request;

class RequestTest extends PHPUnit_Framework_TestCase
{
    public function testRequestMustReturnJson()
    {
        $jsonResult = [
            'success' => true,
            'data' => [
                'foo' => 'bar'
            ]
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($jsonResult))
        ]);

        $handler = HandlerStack::create($mock);
        $guzzleClientMock = new Client(['handler' => $handler]);

        $request = new Request($guzzleClientMock);
        $requestResult = $request->get('persons');

        $this->assertEquals($jsonResult['data'], $requestResult);
    }

    public function testAnExceptionMustBeThrownWhenTheRequestWasUnsuccessful()
    {
        $mock = new MockHandler([
            new Response(404)
        ]);

        $handler = HandlerStack::create($mock);
        $guzzleClientMock = new Client(['handler' => $handler]);

        $this->setExpectedException(\Exception::class);

        $request = new Request($guzzleClientMock);
        $request->get('/persons');
    }
}
