<?php

namespace Matteao\AliyunSms\Tests;

use Matteao\AliyunSms\AliyunSms;
use PHPUnit\Framework\TestCase;
use Matteao\AliyunSms\Exceptions\HttpException;
use Matteao\AliyunSms\Exceptions\InvalidArgumentException;

class AliyunSmsTest extends TestCase
{
    //参数异常检查
    public function testInvalidArgumentsException()
    {
        $aliyunSms = new AliyunSms('mock-key', 'mock-secret', 'mock-signname');
        $this->expectException(InvalidArgumentException::class);
        $aliyunSms->sendSms('', '', '');
    }
}
