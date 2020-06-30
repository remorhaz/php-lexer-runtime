<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\IO\Exception;

use Exception;
use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\IO\Exception\InvalidSymbolCodeException;
use Remorhaz\Lexer\Runtime\Token\AttributeInterface;

/**
 * @covers \Remorhaz\Lexer\Runtime\IO\Exception\InvalidSymbolCodeException
 */
class InvalidSymbolCodeExceptionTest extends TestCase
{

    public function testGetMessage_Constructed_ReturnsMatchingValue(): void
    {
        $attribute = $this->createMock(AttributeInterface::class);
        $exception = new InvalidSymbolCodeException($attribute);
        self::assertSame('Invalid symbol code', $exception->getMessage());
    }

    public function testGetAttribute_ConstructedWithAttributes_ReturnsSameInstance(): void
    {
        $attribute = $this->createMock(AttributeInterface::class);
        $exception = new InvalidSymbolCodeException($attribute);
        self::assertSame($attribute, $exception->getAttribute());
    }

    public function testGetCode_Always_ReturnsZero(): void
    {
        $attribute = $this->createMock(AttributeInterface::class);
        $exception = new InvalidSymbolCodeException($attribute);
        self::assertSame(0, $exception->getCode());
    }

    public function testGetPrevious_ConstructedWithoutPrevious_ReturnsNull(): void
    {
        $attribute = $this->createMock(AttributeInterface::class);
        $exception = new InvalidSymbolCodeException($attribute);
        self::assertNull($exception->getPrevious());
    }

    public function testGetPrevious_ConstructedWithPrevious_ReturnsSameInstance(): void
    {
        $attribute = $this->createMock(AttributeInterface::class);
        $previous = new Exception();
        $exception = new InvalidSymbolCodeException($attribute, $previous);
        self::assertSame($previous, $exception->getPrevious());
    }
}
