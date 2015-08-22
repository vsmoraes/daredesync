<?php

namespace Sync\Otrs\Repository;

use PDO;
use Sync\Otrs\Entity\CustomerCompany as CustomerCompanyEntity;
use Sync\Support\Database;
use Sync\Support\Traits\ArrayAsEntityCollection;

class CustomerCompany
{
    use ArrayAsEntityCollection;

    /**
     * @var Database
     */
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function getAll()
    {
        $sql = 'SELECT * FROM customer_company ORDER BY customer_id';
        $result = $this->database->query($sql);

        return $this->asEntityCollection($result->fetchAll(), CustomerCompanyEntity::class);
    }

    public function find($customer_id)
    {
        $sql = 'SELECT * FROM customer_company WHERE customer_id = ?';
        $result = $this->database->query($sql, [$customer_id]);

        return new CustomerCompanyEntity($result->fetch(PDO::FETCH_ASSOC));
    }

    public function findByTaxId($tax_id)
    {
        $sql = 'SELECT * FROM customer_company WHERE comments = ?';
        $result = $this->database->query($sql, [$tax_id]);

        return new CustomerCompanyEntity($result->fetch(PDO::FETCH_ASSOC));
    }
}
