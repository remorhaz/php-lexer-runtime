<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\Token\Exception;

use Exception;
use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\Token\Exception\MatcherKeyNotFoundException;

/**
 * @covers \Remorhaz\Lexer\Runtime\Token\Exception\MatcherKeyNotFoundException
 */
class MatcherKeyNotFoundExceptionTest extends TestCase
{

    public function testGetMessage_Constructed_ReturnsMatchingValue(): void
    {
        $exception = new MatcherKeyNotFoundException();
        self::assertSame('Matcher key not found', $exception->getMessage());
    }

    public function testGetCode_Always_ReturnsZero(): void
    {
        $exception = new MatcherKeyNotFoundException();
        self::assertSame(0, $exception->getCode());
    }

    public function testGetPrevious_ConstructedWithoutPrevious_ReturnsNull(): void
    {
        $exception = new MatcherKeyNotFoundException();
        self::assertNull($exception->getPrevious());
    }

    public function testGetPrevious_ConstructedWithPrevious_ReturnsSameInstance(): void
    {
        $previous = new Exception();
        $exception = new MatcherKeyNotFoundException($previous);
        self::assertSame($previous, $exception->getPrevious());
    }
}
