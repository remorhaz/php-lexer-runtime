<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\IO\Exception;

use Exception;
use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\IO\Exception\NonEmptyLexemeException;
use Remorhaz\Lexer\Runtime\IO\LexemeInterface;

/**
 * @covers \Remorhaz\Lexer\Runtime\IO\Exception\NonEmptyLexemeException
 */
class NonEmptyLexemeExceptionTest extends TestCase
{

    public function testGetMessage_Constructed_ReturnsMatchingValue(): void
    {
        $exception = new NonEmptyLexemeException($this->createMock(LexemeInterface::class));
        self::assertSame('Empty lexeme can\'t include non-empty one', $exception->getMessage());
    }

    public function testGetLexeme_ConstructedWithLexeme_ReturnsSameInstance(): void
    {
        $lexeme = $this->createMock(LexemeInterface::class);
        $exception = new NonEmptyLexemeException($lexeme);
        self::assertSame($lexeme, $exception->getLexeme());
    }

    public function testGetCode_Always_ReturnsZero(): void
    {
        $exception = new NonEmptyLexemeException($this->createMock(LexemeInterface::class));
        self::assertSame(0, $exception->getCode());
    }

    public function testGetPrevious_ConstructedWithoutPrevious_ReturnsNull(): void
    {
        $exception = new NonEmptyLexemeException($this->createMock(LexemeInterface::class));
        self::assertNull($exception->getPrevious());
    }

    public function testGetPrevious_ConstructedWithPrevious_ReturnsSameInstance(): void
    {
        $previous = new Exception();
        $exception = new NonEmptyLexemeException(
            $this->createMock(LexemeInterface::class),
            $previous
        );
        self::assertSame($previous, $exception->getPrevious());
    }
}
