<?php

namespace LarusVK\Sections\Methods;

final class FieldCollection implements \IteratorAggregate, \ArrayAccess
{

    const API_VERSION_FIELD = 'v';

    const ACCESS_TOKEN_FIELD = 'access_token';

    const LANG_FIELD = 'lang';

    const HTTPS_FIELD = 'https';

    const TEST_MODE_FIELD = 'test_mode';

    /**
     * Reserved fields, which will be set by LarusVK automatically
     *
     * @var array
     */
    private $forbidden_fields = [
        self::API_VERSION_FIELD
    ];

    private $fields;


    public function getIterator()
    {
        return new \ArrayIterator($this->fields);
    }

    public function offsetExists($offset)
    {
        return isset($this->fields[$offset]);
    }


    public function offsetGet($offset)
    {
        if (!$this->offsetExists($offset)) {
            throw new \RuntimeException(
                __CLASS__ . " doesn't contain offset: `{$offset}`"
            );
        }

        return $this->fields[$offset];
    }


    public function offsetSet($offset, $value)
    {

        if (in_array($offset, $this->forbidden_fields)) {
            throw new \InvalidArgumentException(
                "Field `{$offset}` can not be setted, it is reserved"
            );
        }

        if(is_array($value)){
            $value = implode(',', $value);
        }


        $this->fields[$offset] = $value;

    }


    public function offsetUnset($offset)
    {
        unset($this->fields[$offset]);
    }

    public function getArray()
    {
        return $this->fields;
    }
    /**
     * Instantiate object from array
     *
     * @param array $fields_array
     * @return self
     */
    public static function fromArray(array $fields_array)
    {
        $object = new self;

        foreach($fields_array as $field_name => $field_value)
        {
            $object[$field_name] = $field_value;
        }

        return $object;
    }


}