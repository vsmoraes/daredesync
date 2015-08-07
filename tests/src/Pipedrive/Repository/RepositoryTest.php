<?php

use Sync\Pipedrive\Repository\Organization as OrganizationRepository;

class RepositoryTest extends PHPUnit_Framework_TestCase
{
    public function testShouldRetrieveOrganizationsCollection()
    {
        $expected = $this->buildResult();

        $requestMock = $this->getMockBuilder('Sync\Pipedrive\Request')
            ->setMethods(['get'])
            ->getMock();

        $requestMock->expects($this->once())
            ->method('get')
            ->will($this->returnValue($expected));

        $repository = new OrganizationRepository($requestMock);
        $result = $repository->all();

        $this->assertCount(3, $result);
        $this->assertEquals($expected[0]['name'], $result[0]->name);
        $this->assertEquals($expected[1]['name'], $result[1]->name);
        $this->assertEquals($expected[2]['name'], $result[2]->name);
    }

    protected function buildResult()
    {
        return [
            [
                'id' => 1,
                'name' => 'Foo bar'
            ],
            [
                'id' => 2,
                'name' => 'Bar biz'
            ],
            [
                'id' => 3,
                'name' => 'Biz foo'
            ]
        ];
    }
}
