<?php

namespace Sync\Support\Traits;

use Sync\Support\EntityCollection;

trait ArrayAsEntityCollection
{
    public function asEntityCollection(array $data, $entityClass)
    {
        $collection = new EntityCollection();

        foreach ($data as $record) {
            $collection->addItem(new $entityClass($record));
        }

        return $collection;
    }
}
