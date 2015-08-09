<?php

namespace Sync\Support;

abstract class Entity
{
    /**
     * Initial attributes values
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Mark if the attributes have changed
     *
     * @var bool
     */
    protected $isDirty = false;

    public function __construct($attributes = [])
    {
        $this->loadArrayAsAttributes($attributes);
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
     * Fill the object's attributes based on an array
     *
     * @param array $attributes
     */
    protected function loadArrayAsAttributes(array $attributes = [])
    {
        foreach ($attributes as $attribute => $value) {
            if (property_exists($this, $attribute)) {
                $this->{$attribute} = $value;
            }
        }
    }

    /**
     * Mark the object as dirty
     *
     * @param $attribute
     * @param $value
     */
    protected function set($attribute, $value)
    {
        $this->{$attribute} = $value;

        $this->markAsDirty();
    }

    /**
     * Retrieve the attributes that have their value changed
     *
     * @return array
     */
    public function getDirty()
    {
        $attributes = [];

        foreach (get_object_vars($this) as $attribute => $value) {
            if ($this->attributeHasChanged($attribute)) {
                $attributes[$attribute] = $this->{$attribute};
            }
        }

        return $attributes;
    }

    /**
     * Return true if the value of the attribute has changed
     *
     * @param $attribute
     *
     * @return bool
     */
    protected function attributeHasChanged($attribute)
    {
        if (! array_key_exists($attribute, $this->attributes)) {
            return false;
        }

        if ($this->attributes[$attribute] == $this->{$attribute}) {
            return false;
        }

        return true;
    }

    /**
     * Mark the object as dirty if one or more attributes have changed
     */
    protected function markAsDirty()
    {
        $dirty = false;

        if (count($this->getDirty()) > 0) {
            $dirty = true;
        }

        $this->isDirty = $dirty;
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
