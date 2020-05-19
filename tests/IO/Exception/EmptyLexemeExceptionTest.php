<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\IO\Exception;

use Exception;
use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\IO\Exception\EmptyLexemeException;

/**
 * @covers \Remorhaz\Lexer\Runtime\IO\Exception\EmptyLexemeException
 */
class EmptyLexemeExceptionTest extends TestCase
{

    public function testGetMessage_Constructed_ReturnsMatchingValue(): void
    {
        $exception = new EmptyLexemeException();
        self::assertSame('Lexeme contains no symbols', $exception->getMessage());
    }

    public function testGetCode_Always_ReturnsZero(): void
    {
        $exception = new EmptyLexemeException();
        self::assertSame(0, $exception->getCode());
    }

    public function testGetPrevious_ConstructedWithoutPrevious_ReturnsNull(): void
    {
        $exception = new EmptyLexemeException();
        self::assertNull($exception->getPrevious());
    }

    public function testGetPrevious_ConstructedWithPrevious_ReturnsSameInstance(): void
    {
        $previous = new Exception();
        $exception = new EmptyLexemeException($previous);
        self::assertSame($previous, $exception->getPrevious());
    }
}
