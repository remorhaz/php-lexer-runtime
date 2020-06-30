<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\Token;

use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\Token\Exception\WrongAttributeTypeException;
use Remorhaz\Lexer\Runtime\Token\StringAttribute;
use Remorhaz\Lexer\Runtime\Unicode\StringInterface;

/**
 * @covers \Remorhaz\Lexer\Runtime\Token\StringAttribute
 */
class StringAttributeTest extends TestCase
{

    public function testAsString_ConstructedWithString_ReturnsSameInstance(): void
    {
        $string = $this->createMock(StringInterface::class);
        $attribute = new StringAttribute($string);
        self::assertSame($string, $attribute->asString());
    }

    public function testAsBoolean_Constructed_ThrowsException(): void
    {
        $attribute = new StringAttribute($this->createMock(StringInterface::class));
        $this->expectException(WrongAttributeTypeException::class);
        $this->expectExceptionMessage('boolean');
        $attribute->asBoolean();
    }

    public function testAsInteger_Constructed_ThrowsException(): void
    {
        $attribute = new StringAttribute($this->createMock(StringInterface::class));
        $this->expectException(WrongAttributeTypeException::class);
        $this->expectExceptionMessage('integer');
        $attribute->asInteger();
    }
}
