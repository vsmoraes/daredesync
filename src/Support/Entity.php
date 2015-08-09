<?php

namespace Sync\Support;

abstract class Entity
{
    protected $attributes = [];
    protected $isDirty = false;

    public function __construct($attributes = [])
    {
        foreach ($attributes as $attribute => $value) {
            if (property_exists($this, $attribute)) {
                $this->{$attribute} = $value;
            }
        }

        $this->attributes = $attributes;
    }

    /**
     * Return if the attributes changed
     *
     * @return bool
     */
    public function isDirty()
    {
        return $this->isDirty;
    }

    /**
     * Getters and setter
     *
     * @param $method
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        $attribute = $this->getAttributeFromMethod($method);

        if (! $attribute) {
            return false;
        }

        if ($this->methodIsSetter($method)) {
            $this->set($attribute, reset($arguments));

            return $this;
        }

        return $this->{$attribute};
    }

    /**
     * Mark the object as dirty
     *
     * @param $attribute
     * @param $value
     */
    protected function set($attribute, $value)
    {
        if ($value != $this->{$attribute}) {
            $this->isDirty = true;
        }

        $this->{$attribute} = $value;
    }

    /**
     * Check if the method is a setter
     *
     * @param $method
     *
     * @return bool
     */
    protected function methodIsSetter($method)
    {
        return substr($method, 0, 3) == 'set';
    }

    /**
     * Get the attribute from getter or setter
     *
     * @param $method
     *
     * @return string|null
     */
    protected function getAttributeFromMethod($method)
    {
        $attribute = preg_replace('/(?!^)[A-Z]{2,}(?=[A-Z][a-z])|[A-Z][a-z]|[0-9]{1,}/', '_$0', $method);
        $attribute = strtolower(substr($attribute, 4));

        if (! property_exists($this, $attribute)) {
            return null;
        }

        return $attribute;
    }
}
