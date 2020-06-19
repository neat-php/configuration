<?php

namespace Neat\Configuration\Test;

use DateTime;
use DateTimeImmutable;
use Neat\Configuration\Property;
use Neat\Configuration\Test\Stub\Properties;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;

class PropertyTest extends TestCase
{
    /**
     * Provide set values
     *
     * @return array
     */
    public function provideSetData()
    {
        return [
            ['integer', null, null],
            ['integer', 1, 1],
            ['integer', '1', 1],
            ['string', null, null],
            ['string', 'Doe', 'Doe'],
            ['string', 3, 3],
            ['boolean', null, null],
            ['boolean', '0', false],
            ['boolean', '1', true],
            ['boolean', 0, false],
            ['boolean', 1, true],
            ['dateTimeImmutable', null, null],
            ['dateTimeImmutable', '2001-02-03', new DateTimeImmutable('2001-02-03 00:00:00')],
            ['dateTimeImmutable', '2001-02-03 04:05:06', new DateTimeImmutable('2001-02-03 04:05:06')],
            ['dateTime', null, null],
            ['dateTime', '2001-02-03', new DateTime('2001-02-03 00:00:00')],
            ['dateTime', '2001-02-03 04:05:06', new DateTime('2001-02-03 04:05:06')],
        ];
    }

    /** @noinspection PhpDocMissingThrowsInspection */
    /**
     * Test set value
     *
     * @dataProvider provideSetData
     * @param string $name
     * @param mixed  $in
     * @param mixed  $out
     */
    public function testSet($name, $in, $out)
    {
        $stub = new Properties();

        /** @noinspection PhpUnhandledExceptionInspection */
        $property = new Property(new ReflectionProperty($stub, $name));
        $property->set($stub, $in);

        if ($out instanceof DateTime || $out instanceof DateTimeImmutable) {
            $this->assertEquals($out, $stub->$name);
        } else {
            $this->assertSame($out, $stub->$name);
        }
    }
}
