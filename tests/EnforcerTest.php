<?php

namespace webman\permission\tests;

use PHPUnit\Framework\TestCase;
use think\facade\Db;
use webman\permission\Permission;

class EnforcerTest extends TestCase
{
    public function setUp():void
    {
        $config  = [
            'host'          => 'dnmp-mysql',
            'port'          => 3306,
            'user'          => 'root',
            'password'      => '123456',
            'database'      => 'webman',
            'timeout'       => 0,
            'charset'       => 'utf8',
        ];
        Db::setConfig($config);
        parent::setUp();
    }

    public function testEnforce()
    {
        $this->assertTrue(Permission::enforce('test1','route_test','method_test'));
        $this->assertFalse(Permission::enforce('test1','err_route_test','err_method_test'));
    }
}