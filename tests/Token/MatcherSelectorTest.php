<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\Token;

use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\Token\Exception\MatcherNotFoundException;
use Remorhaz\Lexer\Runtime\Token\Exception\MatcherNotRestoredException;
use Remorhaz\Lexer\Runtime\Token\MatcherSelector;
use Remorhaz\Lexer\Runtime\Token\TokenMatcherInterface;

/**
 * @covers \Remorhaz\Lexer\Runtime\Token\MatcherSelector
 */
class MatcherSelectorTest extends TestCase
{

    public function testConstruct_ConstructedWithoutMatchers_ThrowsException(): void
    {
        $this->expectException(MatcherNotFoundException::class);
        new MatcherSelector([], 'a');
    }

    public function testGetMatcher_ConstructedWithStartKey_ReturnsMatcherWithSameKey(): void
    {
        $matcherA = $this->createMock(TokenMatcherInterface::class);
        $matcherB = $this->createMock(TokenMatcherInterface::class);
        $selector = new MatcherSelector(['a' => $matcherA, 'b' => $matcherB], 'b');
        self::assertSame($matcherB, $selector->getMatcher());
    }

    public function testSetMatcher_ConstructedWithoutGivenKey_ThrowsException(): void
    {
        $matcher = $this->createMock(TokenMatcherInterface::class);
        $selector = new MatcherSelector(['a' => $matcher], 'a');
        $this->expectException(MatcherNotFoundException::class);
        $selector->setMatcher('b');
    }

    public function testSetMatcher_ConstructedWithMatcherByGivenKey_SetsSameInstance(): void
    {
        $matcherA = $this->createMock(TokenMatcherInterface::class);
        $matcherB = $this->createMock(TokenMatcherInterface::class);
        $selector = new MatcherSelector(['a' => $matcherA, 'b' => $matcherB], 'a');
        $selector->setMatcher('b');
        self::assertSame($matcherB, $selector->getMatcher());
    }

    public function testRestoreMatcher_MatcherIsSet_RestoresActiveMatcher(): void
    {
        $matcherA = $this->createMock(TokenMatcherInterface::class);
        $matcherB = $this->createMock(TokenMatcherInterface::class);
        $selector = new MatcherSelector(['a' => $matcherA, 'b' => $matcherB], 'a');
        $selector->setMatcher('b');
        $selector->restoreMatcher();
        self::assertSame($matcherA, $selector->getMatcher());
    }

    public function testRestoreMatcher_MatcherNotSet_ThrowsException(): void
    {
        $matcher = $this->createMock(TokenMatcherInterface::class);
        $selector = new MatcherSelector(['a' => $matcher], 'a');
        $this->expectException(MatcherNotRestoredException::class);
        $selector->restoreMatcher();
    }
}
