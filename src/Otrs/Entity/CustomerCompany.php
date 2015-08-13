<?php

namespace Sync\Otrs\Entity;

use Illuminate\Database\Eloquent\Model;

class CustomerCompany extends Model
{
    /**
     * Table name
     * 
     * @var string
     */
    protected $table = 'customer_company';

    /**
     * Primary key name
     *
     * @var string
     */
    protected $primaryKey = 'customer_id';

    /**
     * Disable timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Columns protected against updates
     *
     * @var array
     */
    protected $guarded = ['customer_id'];
}
