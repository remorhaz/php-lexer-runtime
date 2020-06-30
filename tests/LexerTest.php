<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test;

use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\IO\SymbolReaderInterface;
use Remorhaz\Lexer\Runtime\Lexer;
use Remorhaz\Lexer\Runtime\Token\MatcherInterface;
use Remorhaz\Lexer\Runtime\Token\MatcherSelectorInterface;
use Remorhaz\Lexer\Runtime\Token\TokenReader;

/**
 * @covers \Remorhaz\Lexer\Runtime\Lexer
 */
class LexerTest extends TestCase
{

    public function testCreateTokenReader_Constructed_ReturnsTokeReaderInstance(): void
    {
        $lexer = new Lexer($this->createMock(MatcherSelectorInterface::class));
        self::assertInstanceOf(
            TokenReader::class,
            $lexer->createTokenReader($this->createMock(SymbolReaderInterface::class))
        );
    }

    public function testCreateTokenReader_GivenSymbolReader_ResultReadsFromSameInstance(): void
    {
        $lexer = new Lexer($this->createMock(MatcherSelectorInterface::class));
        $symbolReader = $this->createMock(SymbolReaderInterface::class);
        $symbolReader
            ->expects(self::atLeastOnce())
            ->method('isFinished');
        $lexer->createTokenReader($symbolReader)->read();
    }

    public function testCreateTokenReader_ConstructedWithMatcherSelector_ResultUsesClonedSelector(): void
    {
        $matcherSelector = $this->createMock(MatcherSelectorInterface::class);
        $lexer = new Lexer($matcherSelector);
        $matcher = $this->createMock(MatcherInterface::class);
        $matcherSelector
            ->method('getMatcher')
            ->willReturn($matcher);
        $assertClonedMatcherSelector = function (MatcherSelectorInterface $selector) use ($matcherSelector): bool {
            return $selector !== $matcherSelector;
        };
        $matcher
            ->expects(self::atLeastOnce())
            ->method('match')
            ->with(self::anything(), self::anything(), self::callback($assertClonedMatcherSelector));
        $lexer->createTokenReader($this->createMock(SymbolReaderInterface::class))->read();
    }
}
