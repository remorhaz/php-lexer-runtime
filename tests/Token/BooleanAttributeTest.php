<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\Token;

use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\Token\BooleanAttribute;
use Remorhaz\Lexer\Runtime\Token\Exception\WrongAttributeTypeException;

/**
 * @covers \Remorhaz\Lexer\Runtime\Token\BooleanAttribute
 */
class BooleanAttributeTest extends TestCase
{

    public function testAsUnicodeString_Constructed_ThrowsException(): void
    {
        $attribute = new BooleanAttribute(true);
        $this->expectException(WrongAttributeTypeException::class);
        $this->expectExceptionMessage('Unicode string');
        $attribute->asString();
    }

    /**
     * @param bool $value
     * @param bool $expectedValue
     * @dataProvider providerAsBoolean
     */
    public function testAsBoolean_ConstructedWithValue_ReturnsSameValue(bool $value, bool $expectedValue): void
    {
        $attribute = new BooleanAttribute($value);
        self::assertSame($expectedValue, $attribute->asBoolean());
    }

    public function providerAsBoolean(): array
    {
        return [
            'True' => [true, true],
            'False' => [false, false],
        ];
    }

    public function testAsInteger_Constructed_ThrowsException(): void
    {
        $attribute = new BooleanAttribute(true);
        $this->expectException(WrongAttributeTypeException::class);
        $this->expectExceptionMessage('integer');
        $attribute->asInteger();
    }
}
