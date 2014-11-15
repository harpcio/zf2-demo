<?php

namespace Application\Library\QueryFilter;

class Condition
{
    const TYPE_EQUAL = 'equal',
        TYPE_BETWEEN = 'between',
        TYPE_MIN = 'min',
        TYPE_MAX = 'max',
        TYPE_STARTS_WITH = 'startswith',
        TYPE_ENDS_WITH = 'endswith',
        TYPE_IN_ARRAY = 'inarray';

    private $types = [
        self::TYPE_EQUAL,
        self::TYPE_BETWEEN,
        self::TYPE_MIN,
        self::TYPE_MAX,
        self::TYPE_STARTS_WITH,
        self::TYPE_ENDS_WITH,
        self::TYPE_IN_ARRAY,
    ];

    /**
     * @var mixed
     */
    private $data;

    /**
     * @var string
     */
    private $type;

    /**
     * @param string $type
     * @param mixed  $data
     */
    public function __construct($type, $data)
    {
        $this->setType($type);
        $this->setData($data);
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
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
}