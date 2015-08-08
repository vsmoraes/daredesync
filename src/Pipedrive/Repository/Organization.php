<?php

namespace Sync\Pipedrive\Repository;

use Sync\Pipedrive\Entity\Organization as OrganizationEntity;
use Sync\Pipedrive\EntityCollection;
use Sync\Pipedrive\Request;

class Organization
{
    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Fetch an organization
     *
     * @param $id
     *
     * @return OrganizationEntity
     */
    public function findById($id)
    {
        return new OrganizationEntity($this->request->get('/organization/' . $id));
    }

    /**
     * Retrieve all organizations
     *
     * @return EntityCollection
     */
    public function all()
    {
        $search_items = $this->request->get('/organizations');
        $collection = new EntityCollection();

        foreach ($search_items as $item) {
            $collection->addItem(new OrganizationEntity($item));
        }

        return $collection;
    }
}
