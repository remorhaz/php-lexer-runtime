<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\Token;

use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\Token\Exception\InvalidMatcherKeyException;
use Remorhaz\Lexer\Runtime\Token\Exception\MatcherNotFoundException;
use Remorhaz\Lexer\Runtime\Token\Exception\MatchersNotFoundException;
use Remorhaz\Lexer\Runtime\Token\Exception\MatcherNotRestoredException;
use Remorhaz\Lexer\Runtime\Token\MatcherInterface;
use Remorhaz\Lexer\Runtime\Token\MatcherSelector;

/**
 * @covers \Remorhaz\Lexer\Runtime\Token\MatcherSelector
 */
class MatcherSelectorTest extends TestCase
{

    public function testConstruct_ConstructedWithoutMatchers_ThrowsException(): void
    {
        $this->expectException(MatchersNotFoundException::class);
        new MatcherSelector([]);
    }

    public function testConstruct_ConstructedWithNonStringMatcherKey_ThrowsException(): void
    {
        $this->expectException(InvalidMatcherKeyException::class);
        new MatcherSelector([1 => $this->createMock(MatcherInterface::class)]);
    }

    public function testGetMatcher_ConstructedWithStartKey_ReturnsMatcherWithSameKey(): void
    {
        $matcherA = $this->createMock(MatcherInterface::class);
        $matcherB = $this->createMock(MatcherInterface::class);
        $selector = new MatcherSelector(['a' => $matcherA, 'b' => $matcherB], 'b');
        self::assertSame($matcherB, $selector->getMatcher());
    }

    public function testGetMatcher_ConstructedWithoutStartKey_ReturnsFirstMatcher(): void
    {
        $matcherA = $this->createMock(MatcherInterface::class);
        $matcherB = $this->createMock(MatcherInterface::class);
        $selector = new MatcherSelector(['a' => $matcherA, 'b' => $matcherB]);
        self::assertSame($matcherA, $selector->getMatcher());
    }

    public function testSetMatcher_ConstructedWithoutGivenKey_ThrowsException(): void
    {
        $matcher = $this->createMock(MatcherInterface::class);
        $selector = new MatcherSelector(['a' => $matcher], 'a');
        $this->expectException(MatcherNotFoundException::class);
        $selector->setMatcher('b');
    }

    public function testSetMatcher_ConstructedWithMatcherByGivenKey_SetsSameInstance(): void
    {
        $matcherA = $this->createMock(MatcherInterface::class);
        $matcherB = $this->createMock(MatcherInterface::class);
        $selector = new MatcherSelector(['a' => $matcherA, 'b' => $matcherB], 'a');
        $selector->setMatcher('b');
        self::assertSame($matcherB, $selector->getMatcher());
    }

    public function testRestoreMatcher_MatcherIsSet_RestoresActiveMatcher(): void
    {
        $matcherA = $this->createMock(MatcherInterface::class);
        $matcherB = $this->createMock(MatcherInterface::class);
        $selector = new MatcherSelector(['a' => $matcherA, 'b' => $matcherB], 'a');
        $selector->setMatcher('b');
        $selector->restoreMatcher();
        self::assertSame($matcherA, $selector->getMatcher());
    }

    public function testRestoreMatcher_MatcherNotSet_ThrowsException(): void
    {
        $matcher = $this->createMock(MatcherInterface::class);
        $selector = new MatcherSelector(['a' => $matcher], 'a');
        $this->expectException(MatcherNotRestoredException::class);
        $selector->restoreMatcher();
    }
}
