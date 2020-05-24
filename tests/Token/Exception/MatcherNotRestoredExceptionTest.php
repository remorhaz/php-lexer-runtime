<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\Token\Exception;

use Exception;
use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\Token\Exception\MatcherNotRestoredException;

/**
 * @covers \Remorhaz\Lexer\Runtime\Token\Exception\MatcherNotRestoredException
 */
class MatcherNotRestoredExceptionTest extends TestCase
{

    public function testGetMessage_Constructed_ReturnsMatchingValue(): void
    {
        $exception = new MatcherNotRestoredException();
        self::assertSame('Matcher not restored', $exception->getMessage());
    }

    public function testGetCode_Always_ReturnsZero(): void
    {
        $exception = new MatcherNotRestoredException();
        self::assertSame(0, $exception->getCode());
    }

    public function testGetPrevious_CreatedWithoutPrevious_ReturnsNull(): void
    {
        $exception = new MatcherNotRestoredException();
        self::assertNull($exception->getPrevious());
    }

    public function testGetPrevious_CreatedWithPrevious_ReturnsSameInstance(): void
    {
        $previous = new Exception();
        $exception = new MatcherNotRestoredException($previous);
        self::assertSame($previous, $exception->getPrevious());
    }
}
