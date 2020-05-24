<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\Token\Exception;

use Exception;
use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\Token\Exception\MatcherNotFoundException;

/**
 * @covers \Remorhaz\Lexer\Runtime\Token\Exception\MatcherNotFoundException
 */
class MatcherNotFoundExceptionTest extends TestCase
{

    public function testGetMessage_Constructed_ReturnsMatchingValue(): void
    {
        $exception = new MatcherNotFoundException('a');
        self::assertSame('Matcher not found: a', $exception->getMessage());
    }

    public function testGetMatcherKey_ConstructedWithMatcherKey_ReturnsSameValue(): void
    {
        $exception = new MatcherNotFoundException('a');
        self::assertSame('a', $exception->getMatcherKey());
    }

    public function testGetCode_Always_ReturnsZero(): void
    {
        $exception = new MatcherNotFoundException('a');
        self::assertSame(0, $exception->getCode());
    }

    public function testGetPrevious_ConstructedWithoutPrevious_ReturnsNull(): void
    {
        $exception = new MatcherNotFoundException('a');
        self::assertNull($exception->getPrevious());
    }

    public function testGetPrevious_ConstructedWithPrevious_ReturnsSameInstance(): void
    {
        $previous = new Exception();
        $exception = new MatcherNotFoundException('a', $previous);
        self::assertSame($previous, $exception->getPrevious());
    }
}
