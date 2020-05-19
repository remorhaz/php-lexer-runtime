<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\Token\Exception;

use Exception;
use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\Token\Exception\AttributeNotFoundException;

/**
 * @covers \Remorhaz\Lexer\Runtime\Token\Exception\AttributeNotFoundException
 */
class AttributeNotFoundExceptionTest extends TestCase
{

    public function testGetMessage_ConstructedWithName_ReturnsMatchingValue(): void
    {
        $exception = new AttributeNotFoundException('a');
        self::assertSame('Token attribute not found: a', $exception->getMessage());
    }

    public function testGetName_ConstructedWithName_ReturnsSameValue(): void
    {
        $exception = new AttributeNotFoundException('a');
        self::assertSame('a', $exception->getName());
    }

    public function testGetCode_Always_ReturnsZero(): void
    {
        $exception = new AttributeNotFoundException('a');
        self::assertSame(0, $exception->getCode());
    }

    public function testGetPrevious_ConstructedWithoutPrevious_ReturnsNull(): void
    {
        $exception = new AttributeNotFoundException('a');
        self::assertNull($exception->getPrevious());
    }

    public function testGetPrevious_ConstructedWithPrevious_ReturnsSameInstance(): void
    {
        $previous = new Exception();
        $exception = new AttributeNotFoundException('a', $previous);
        self::assertSame($previous, $exception->getPrevious());
    }
}
