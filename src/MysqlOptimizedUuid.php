<?php

/**
 * This file is part of the MysqlOptimizedUuid package.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 */

namespace MysqlOptimizedUuid;

use Ramsey\Uuid\Uuid;

/**
 * Class MysqlOptimizedUuid.
 *
 * @package MysqlOptimizedUuid
 * @author  Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @link    https://github.com/lorenzomar/mysql-optimized-uuid.git
 */
class MysqlOptimizedUuid
{
    /**
     * @var string
     */
    protected $value;

    /**
     * fromUuid.
     *
     * @return static
     */
    public static function generate()
    {
        $uuid = Uuid::uuid1()->toString();

        return new static(substr($uuid, 14, 4) . substr($uuid, 9, 4) . substr($uuid, 0, 8) . substr($uuid, 19, 4) . substr($uuid, 24));
    }

    public function __construct($value)
    {
        if (strlen($value) != 32) {
            throw new \InvalidArgumentException("Invalid mysql entity id");
        }

        $this->value = (string)$value;
    }

    /**
     * fromMysqlBin.
     *
     * @param string $binValue
     *
     * @return static
     */
    public static function fromMysqlBin($binValue)
    {
        return new static(bin2hex($binValue));
    }

    /**
     * toMysqlBin.
     *
     * @return string
     */
    public function toMysqlBin()
    {
        return hex2bin($this->value);
    }

    /**
     * sameValueAs.
     *
     * @param MysqlOptimizedUuid $mysqlOptimizedUuid
     *
     * @return bool
     */
    public function sameValueAs(MysqlOptimizedUuid $mysqlOptimizedUuid)
    {
        return (string)$this === (string)$mysqlOptimizedUuid;
    }

    /**
     * __toString.
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->value;
    }

    /**
     * __clone.
     *
     * @return static
     */
    public function __clone()
    {
        return new static($this->value);
    }
}