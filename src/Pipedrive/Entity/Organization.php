<?php

namespace Sync\Pipedrive\Entity;

use Sync\Support\Entity;

class Organization extends Entity
{
    const API_TAX_ID = '963783ddbb8c1de794ebca6b46ead2e6609dfed9';

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

    /**
     * Map tax ID from the api
     *
     * @var string
     */
    protected $tax_id;

    public function __construct($attributes)
    {
        if (array_key_exists(self::API_TAX_ID, $attributes)) {
            $attributes['tax_id'] = $attributes[self::API_TAX_ID];
        }

        parent::__construct($attributes);
    }
}
