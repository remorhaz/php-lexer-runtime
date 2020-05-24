<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\Exception;

use Exception;
use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\Exception\MatchersNotFoundException;

/**
 * @covers \Remorhaz\Lexer\Runtime\Exception\MatchersNotFoundException
 */
class MatchersNotFoundExceptionTest extends TestCase
{

    public function testGetMessage_Constructed_ReturnsMatchingValue(): void
    {
        $exception = new MatchersNotFoundException();
        self::assertSame('No matchers provided', $exception->getMessage());
    }

    public function testGetCode_Always_ReturnsZero(): void
    {
        $exception = new MatchersNotFoundException();
        self::assertSame(0, $exception->getCode());
    }

    public function testGetPrevious_ConstructedWithoutPrevious_ReturnsNull(): void
    {
        $exception = new MatchersNotFoundException();
        self::assertNull($exception->getPrevious());
    }

    public function testGetPrevious_ConstructedWithPrevious_ReturnsSameInstance(): void
    {
        $previous = new Exception();
        $exception = new MatchersNotFoundException($previous);
        self::assertSame($previous, $exception->getPrevious());
    }
}
