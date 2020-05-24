<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\Token\Exception;

use Exception;
use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\Token\Exception\TokenNotMatchedException;

/**
 * @covers \Remorhaz\Lexer\Runtime\Token\Exception\TokenNotMatchedException
 */
class TokenNotMatchedExceptionTest extends TestCase
{

    public function testGetMessage_Constructed_ReturnsMatchingValue(): void
    {
        $exception = new TokenNotMatchedException([]);
        self::assertSame('Token not matched', $exception->getMessage());
    }

    public function testGetOffsets_ConstructedWithOffsets_ReturnsSameValue(): void
    {
        $exception = new TokenNotMatchedException([1, 2]);
        self::assertSame([1, 2], $exception->getOffsets());
    }

    public function testGetCode_Always_ReturnsZero(): void
    {
        $exception = new TokenNotMatchedException([]);
        self::assertSame(0, $exception->getCode());
    }

    public function testGetPrevious_ConstructedWithoutPrevious_ReturnsNull(): void
    {
        $exception = new TokenNotMatchedException([]);
        self::assertNull($exception->getPrevious());
    }

    public function testGetPrevious_ConstructedWithPrevious_ReturnsSameInstance(): void
    {
        $previous = new Exception();
        $exception = new TokenNotMatchedException([], $previous);
        self::assertSame($previous, $exception->getPrevious());
    }
}
