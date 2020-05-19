<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\IO\Exception;

use Exception;
use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\IO\Exception\InvalidSymbolCodeException;

/**
 * @covers \Remorhaz\Lexer\Runtime\IO\Exception\InvalidSymbolCodeException
 */
class InvalidSymbolCodeExceptionTest extends TestCase
{

    public function testGetMessage_Constructed_ReturnsMatchingValue(): void
    {
        $exception = new InvalidSymbolCodeException(1);
        self::assertSame('Invalid symbol code', $exception->getMessage());
    }

    /**
     * @param $value
     * @param $expectedValue
     * @dataProvider providerSymbolCode
     */
    public function testGetSymbolCode_ConstructedWithValue_ReturnsSameValue($value, $expectedValue): void
    {
        $exception = new InvalidSymbolCodeException($value);
        self::assertSame($expectedValue, $exception->getSymbolCode());
    }

    public function providerSymbolCode(): array
    {
        return [
            'Integer value' => [1, 1],
            'String value' => ['a', 'a'],
        ];
    }

    public function testGetCode_Always_ReturnsZero(): void
    {
        $exception = new InvalidSymbolCodeException(1);
        self::assertSame(0, $exception->getCode());
    }

    public function testGetPrevious_ConstructedWithoutPrevious_ReturnsNull(): void
    {
        $exception = new InvalidSymbolCodeException(1);
        self::assertNull($exception->getPrevious());
    }

    public function testGetPrevious_ConstructedWithPrevious_ReturnsSameInstance(): void
    {
        $previous = new Exception();
        $exception = new InvalidSymbolCodeException(1, $previous);
        self::assertSame($previous, $exception->getPrevious());
    }
}
