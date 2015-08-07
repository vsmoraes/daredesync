<?php

namespace Sync\Pipedrive\Entity;

class Organization extends Entity
{
    /**
     * ID
     *
     * @var int
     */
    public $id;

    /**
     * Name
     *
     * @var string
     */
    public $name;

    /**
     * Address
     *
     * @var string
     */
    public $address;

    /**
     * Zip code
     *
     * @var string
     */
    public $address_postal_code;

    /**
     * City
     *
     * @var string
     */
    public $address_admin_area_level_1;
}
