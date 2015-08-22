<?php

namespace Sync\Otrs\Entity;

use Sync\Support\Entity;

class CustomerCompany extends Entity
{
    protected $customer_id;
    protected $name;
    protected $street;
    protected $zip;
    protected $country;
    protected $url;
    protected $comments;
    protected $valid_id;
    protected $create_time;
    protected $create_by;
    protected $change_date;
    protected $change_by;
}
