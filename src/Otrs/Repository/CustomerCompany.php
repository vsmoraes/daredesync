<?php

namespace Sync\Otrs\Repository;

use Sync\Otrs\Entity\CustomerCompany as CustomerCompanyEntity;

class CustomerCompany
{
    /**
     * @var CustomerCompanyEntity
     */
    private $model;

    public function __construct(CustomerCompanyEntity $model)
    {
        $this->model = $model;
    }

    /**
     * Find company by tax id
     *
     * @param $tax_id
     *
     * @return mixed
     */
    public function findByTaxId($tax_id)
    {
        return $this->model
            ->where('comments', '=', $tax_id)
            ->find();
    }

    /**
     * Fetch a company
     *
     * @param $id
     *
     * @return mixed
     */
    public function findById($id)
    {
        return $this->model
            ->find($id);
    }

    /**
     * Retrieve all Companies
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return $this->model
            ->all();
    }
}
