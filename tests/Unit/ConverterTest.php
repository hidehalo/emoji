<?php

namespace Hidehalo\Emoji\Tests;

use Hidehalo\Emoji\Parser;
use Hidehalo\Emoji\Converter;
use PHPUnit\Framework\TestCase;
use Hidehalo\Emoji\Protocol\ProtocolInterface;

class ConverterTest extends TestCase
{
    const ENCODE = 'encode';
    const DECODE = 'decode';

    /**
     * @dataProvider converterProvider
     *
     * @return void
     */
    public function testEncode(Converter $conv)
    {
        $ret = $conv->encode('😂');
        $this->assertSame(self::ENCODE, $ret);
    }

    /**
     * @dataProvider converterProvider
     *
     * @return void
     */
    public function testDecode(Converter $conv)
    {
        $ret = $conv->decode('anything');
        $this->assertSame(self::DECODE, $ret);
    }

    public function converterProvider()
    {
        $protoMock = $this->getProtocolMock();

        return [
            [ new Converter(new Parser, $protoMock) ]
        ];
    }

    private function getProtocolMock()
    {
        $proto = $this->getMockBuilder(ProtocolInterface::class)
            ->setMethods(['encode', 'decode', 'getPattern', 'getFormat'])
            ->getMock();

        $proto->expects($this->any())
            ->method('encode')
            ->willReturn(self::ENCODE);

        $proto->expects($this->any())
            ->method('decode')
            ->willReturn(self::DECODE);

        $proto->expects($this->any())
            ->method('getPattern')
            ->willReturn('/\w+/');

        $proto->expects($this->any())
            ->method('getFormat')
            ->willReturn('');
        
        return $proto;
    }
}