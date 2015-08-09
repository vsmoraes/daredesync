<?php

use Sync\Support\EntityCollection;
use Sync\Pipedrive\Entity\Organization;

class EntityCollectionTest extends PHPUnit_Framework_TestCase
{
    public function testShowAddAnItem()
    {
        $item = new Organization([
            'id' => 1,
            'name' => 'Foo bar'
        ]);

        $collection = new EntityCollection();
        $collection->addItem($item);

        $this->assertCount(1, $collection);
        $this->assertEquals($item, $collection[0]);
    }

    public function testShowAddMultipleItems()
    {
        $items = [
            new Organization([
                'id' => 1,
                'name' => 'Foo bar'
            ]),
            new Organization([
                'id' => 2,
                'name' => 'Bar baz'
            ]),
            new Organization([
                'id' => 3,
                'name' => 'Baz foo'
            ])
        ];

        $collection = new EntityCollection();
        $collection->addItems($items);

        $this->assertCount(3, $collection);
        $this->assertEquals($items[0], $collection[0]);
        $this->assertEquals($items[1], $collection[1]);
        $this->assertEquals($items[2], $collection[2]);
    }
}
