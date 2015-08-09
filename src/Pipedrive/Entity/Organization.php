<?php

namespace Sync\Pipedrive\Entity;

class Organization extends Entity
{
    /**
     * ID
     *
     * @var int
     */
    protected $id;

    /**
     * Name
     *
     * @var string
     */
    protected $name;

    /**
     * Address
     *
     * @var string
     */
    protected $address;

    /**
     * Zip code
     *
     * @var string
     */
    protected $address_postal_code;

    /**
     * City
     *
     * @var string
     */
    protected $address_admin_area_level_1;
}
