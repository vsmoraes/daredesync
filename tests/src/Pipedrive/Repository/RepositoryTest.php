<?php

use Sync\Pipedrive\Entity\Organization;
use Sync\Pipedrive\Repository\Organization as OrganizationRepository;

class RepositoryTest extends PHPUnit_Framework_TestCase
{
    public function testShouldRetrieveAnOrganization()
    {
        $expected = $this->buildResult()[0];

        $requestMock = $this->getMockBuilder('Sync\Pipedrive\Request')
            ->setMethods(['get'])
            ->getMock();

        $requestMock->expects($this->once())
            ->method('get')
            ->will($this->returnValue($expected));

        $repository = new OrganizationRepository($requestMock);
        $result = $repository->findById($expected['id']);

        $this->assertInstanceOf(Organization::class, $result);
        $this->assertEquals($expected['name'], $result->getName());
    }

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
        $this->assertEquals($expected[0]['name'], $result[0]->getName());
        $this->assertEquals($expected[1]['name'], $result[1]->getName());
        $this->assertEquals($expected[2]['name'], $result[2]->getName());
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
