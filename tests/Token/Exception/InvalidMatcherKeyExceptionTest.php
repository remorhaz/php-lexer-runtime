<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\Token\Exception;

use Exception;
use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\Token\Exception\InvalidMatcherKeyException;

/**
 * @covers \Remorhaz\Lexer\Runtime\Token\Exception\InvalidMatcherKeyException
 */
class InvalidMatcherKeyExceptionTest extends TestCase
{

    public function testGetMessage_Constructed_ReturnsMatchingValue(): void
    {
        $exception = new InvalidMatcherKeyException(null);
        self::assertSame('Invalid matcher key', $exception->getMessage());
    }

    public function testGetMatcherKey_ConstructedWithMatcherKey_ReturnsSameValue(): void
    {
        $exception = new InvalidMatcherKeyException(1);
        self::assertSame(1, $exception->getMatcherKey());
    }

    public function testGetCode_Always_ReturnsZero(): void
    {
        $exception = new InvalidMatcherKeyException(null);
        self::assertSame(0, $exception->getCode());
    }

    public function testGetPrevious_ConstructedWithoutPrevious_ReturnsNull(): void
    {
        $exception = new InvalidMatcherKeyException(1);
        self::assertNull($exception->getPrevious());
    }

    public function testGetPrevious_ConstructedwithPrevious_ReturnsSameInstance(): void
    {
        $previous = new Exception();
        $exception = new InvalidMatcherKeyException(null, $previous);
        self::assertSame($previous, $exception->getPrevious());
    }
}
