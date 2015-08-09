<?php

use Sync\Support\Entity;

class EntityStub extends Entity
{
    protected $id;
    protected $name;
}

class EntityTest extends PHPUnit_Framework_TestCase
{
    public function testEntityAttributesMustBePopulated()
    {
        $data = [
            'id' => 2,
            'name' => 'Foo Bar'
        ];
        $stub = new EntityStub($data);

        $this->assertEquals($data['id'], $stub->getId());
        $this->assertEquals($data['name'], $stub->getName());
    }

    public function testEntityMustBeMarkedAsDirty()
    {
        $data = [
            'id' => 2,
            'name' => 'Foo Bar'
        ];
        $dirty = [
            'id' => 10,
            'name' => 'Biz Baz'
        ];

        $stub = new EntityStub($data);
        $stub->setId($dirty['id']);
        $stub->setName($dirty['name']);

        $this->assertTrue($stub->isDirty());
        $this->assertEquals($dirty, $stub->getDirty());
    }
}
