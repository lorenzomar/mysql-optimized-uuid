<?php

/**
 * This file is part of the MysqlOptimizedUuid package.
 *
 * (c) Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 */

namespace MysqlOptimizedUuid\Tests;

use MysqlOptimizedUuid\MysqlOptimizedUuid;
use Ramsey\Uuid\Uuid;

/**
 * Class MysqlOptimizedUuidTest.
 *
 * @package MysqlOptimizedUuid
 * @author  Lorenzo Marzullo <marzullo.lorenzo@gmail.com>
 * @link    https://github.com/lorenzomar/mysql-optimized-uuid.git
 */
class MysqlOptimizedUuidTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $stringId;

    public function setUp()
    {
        $uuid           = Uuid::uuid1()->toString();
        $this->stringId = substr($uuid, 14, 4) . substr($uuid, 9, 4) . substr($uuid, 0, 8) . substr($uuid, 19, 4) . substr($uuid, 24);
    }

    public function testGenerate()
    {
        $id = MysqlOptimizedUuid::generate();

        $this->assertInstanceOf('MysqlOptimizedUuid\MysqlOptimizedUuid', $id);
    }

    public function testSameValueAs()
    {
        $id1 = new MysqlOptimizedUuid($this->stringId);
        $id2 = new MysqlOptimizedUuid($this->stringId);

        $this->assertTrue($id1->sameValueAs($id2));
        $this->assertTrue($id2->sameValueAs($id1));
    }

    public function testClone()
    {
        $id1 = new MysqlOptimizedUuid($this->stringId);
        $id2 = clone $id1;

        $this->assertTrue($id1->sameValueAs($id2));
        $this->assertNotSame($id1, $id2);
    }
}