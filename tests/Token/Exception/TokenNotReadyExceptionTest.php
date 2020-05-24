<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\Token\Exception;

use Exception;
use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\Token\Exception\TokenNotReadyException;

/**
 * @covers \Remorhaz\Lexer\Runtime\Token\Exception\TokenNotReadyException
 */
class TokenNotReadyExceptionTest extends TestCase
{

    public function testGetMessage_Constructed_ReturnsMatchingValue(): void
    {
        $exception = new TokenNotReadyException();
        self::assertSame('Token is not ready yet', $exception->getMessage());
    }

    public function testGetCode_Always_ReturnsZero(): void
    {
        $exception = new TokenNotReadyException();
        self::assertSame(0, $exception->getCode());
    }

    public function testGetPrevious_ConstructedWithoutPrevious_ReturnsNull(): void
    {
        $exception = new TokenNotReadyException();
        self::assertNull($exception->getPrevious());
    }

    public function testGetPrevious_ConstructedWithPrevious_ReturnsSameInstance(): void
    {
        $previous = new Exception();
        $exception = new TokenNotReadyException($previous);
        self::assertSame($previous, $exception->getPrevious());
    }
}
