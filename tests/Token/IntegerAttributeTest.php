<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\Token;

use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\Token\IntegerAttribute;
use Remorhaz\Lexer\Runtime\Token\Exception\WrongAttributeTypeException;

/**
 * @covers \Remorhaz\Lexer\Runtime\Token\IntegerAttribute
 */
class IntegerAttributeTest extends TestCase
{

    public function testAsUnicodeString_Constructed_ThrowsException(): void
    {
        $attribute = new IntegerAttribute(1);
        $this->expectException(WrongAttributeTypeException::class);
        $this->expectExceptionMessage('Unicode string');
        $attribute->asString();
    }

    public function testAsBoolean_Constructed_ThrowsException(): void
    {
        $attribute = new IntegerAttribute(1);
        $this->expectException(WrongAttributeTypeException::class);
        $this->expectExceptionMessage('boolean');
        $attribute->asBoolean();
    }

    public function testAsInteger_Constructed_ThrowsException(): void
    {
        $attribute = new IntegerAttribute(1);
        self::assertSame(1, $attribute->asInteger());
    }
}
