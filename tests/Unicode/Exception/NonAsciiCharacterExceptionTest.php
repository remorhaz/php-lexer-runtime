<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\Unicode\Exception;

use Exception;
use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\Unicode\Exception\NonAsciiCharacterException;

/**
 * @covers \Remorhaz\Lexer\Runtime\Unicode\Exception\NonAsciiCharacterException
 */
class NonAsciiCharacterExceptionTest extends TestCase
{

    public function testGetMessage_ConstructedWithCharacter_ReturnsMatchingValue(): void
    {
        $exception = new NonAsciiCharacterException(127);
        self::assertSame('Character 0x7F is not in ASCII range', $exception->getMessage());
    }

    public function testGetCharacter_ConstructedWithCharacter_ReturnsSameValue(): void
    {
        $exception = new NonAsciiCharacterException(1);
        self::assertSame(1, $exception->getCharacter());
    }

    public function testGetCode_Always_ReturnsZero(): void
    {
        $exception = new NonAsciiCharacterException(1);
        self::assertSame(0, $exception->getCode());
    }

    public function testGetPrevious_ConstructedWithoutPrevious_ReturnsNull(): void
    {
        $exception = new NonAsciiCharacterException(0);
        self::assertNull($exception->getPrevious());
    }

    public function testGetPrevious_ConstructedWithPrevious_ReturnsSameInstance(): void
    {
        $previous = new Exception();
        $exception = new NonAsciiCharacterException(0, $previous);
        self::assertSame($previous, $exception->getPrevious());
    }
}
