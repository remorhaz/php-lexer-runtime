<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\IO\Exception;

use Exception;
use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\IO\Exception\UnexpectedEndOfInputException;

/**
 * @covers \Remorhaz\Lexer\Runtime\IO\Exception\UnexpectedEndOfInputException
 */
class UnexpectedEndOfInputExceptionTest extends TestCase
{

    public function testGetMessage_ConstructedWithOffset_ReturnsMatchingValue(): void
    {
        $exception = new UnexpectedEndOfInputException(1);
        self::assertSame('Unexpected end of input at offset 1', $exception->getMessage());
    }

    public function testGetOffset_ConstructedWithOffset_ReturnsSameValue(): void
    {
        $exception = new UnexpectedEndOfInputException(1);
        self::assertSame(1, $exception->getOffset());
    }

    public function testGetCode_Always_ReturnsZero(): void
    {
        $exception = new UnexpectedEndOfInputException(1);
        self::assertSame(0, $exception->getCode());
    }

    public function testGetPrevious_ConstructedWithoutPrevious_ReturnsNull(): void
    {
        $exception = new UnexpectedEndOfInputException(1);
        self::assertNull($exception->getPrevious());
    }

    public function testGetPrevious_ConstructedWithPrevious_ReturnsSameInstance(): void
    {
        $previous = new Exception();
        $exception = new UnexpectedEndOfInputException(1, $previous);
        self::assertSame($previous, $exception->getPrevious());
    }
}
