<?php

namespace Library\QueryFilter;

class Criteria
{
    const TYPE_CONDITION_EQUAL = 'equal',
        TYPE_CONDITION_BETWEEN = 'between',
        TYPE_CONDITION_MIN = 'min',
        TYPE_CONDITION_MAX = 'max',
        TYPE_CONDITION_STARTS_WITH = 'startswith',
        TYPE_CONDITION_ENDS_WITH = 'endswith',
        TYPE_CONDITION_IN_ARRAY = 'inarray',

        TYPE_SPECIAL_LIMIT = 'limit',
        TYPE_SPECIAL_OFFSET = 'offset',
        TYPE_SPECIAL_SORT = 'sort',
        TYPE_SPECIAL_FIELDS = 'fields';


    private $types = [
        self::TYPE_CONDITION_EQUAL,
        self::TYPE_CONDITION_BETWEEN,
        self::TYPE_CONDITION_MIN,
        self::TYPE_CONDITION_MAX,
        self::TYPE_CONDITION_STARTS_WITH,
        self::TYPE_CONDITION_ENDS_WITH,
        self::TYPE_CONDITION_IN_ARRAY,
        self::TYPE_SPECIAL_LIMIT,
        self::TYPE_SPECIAL_OFFSET,
        self::TYPE_SPECIAL_SORT,
        self::TYPE_SPECIAL_FIELDS,
    ];

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $key;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @param string $type
     * @param string $key
     * @param mixed  $value
     */
    public function __construct($type, $key, $value)
    {
        $this->setType($type);
        $this->setKey($key);
        $this->setValue($value);
    }

    /**
     * @param string $type
     *
     * @throws Exception\UnsupportedTypeException
     */
    public function setType($type)
    {
        if (!in_array($type, $this->types)) {
            throw new Exception\UnsupportedTypeException(sprintf('Unsupported type: %s', $type));
        }

        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $columnName
     */
    public function setKey($columnName)
    {
        $this->key = $columnName;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param mixed $data
     */
    public function setValue($data)
    {
        $this->value = $data;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}