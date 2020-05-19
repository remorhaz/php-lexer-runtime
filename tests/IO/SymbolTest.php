<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\IO;

use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\IO\LexemeInterface;
use Remorhaz\Lexer\Runtime\IO\NullLexeme;
use Remorhaz\Lexer\Runtime\IO\Symbol;

/**
 * @covers \Remorhaz\Lexer\Runtime\IO\Symbol
 */
class SymbolTest extends TestCase
{

    public function testGetOffset_ConstructedWithOffset_ReturnsSameValue(): void
    {
        $symbol = new Symbol(1, 2, new NullLexeme());
        self::assertSame(1, $symbol->getOffset());
    }

    public function testGetCode_ConstructedWithCode_ReturnsSameValue(): void
    {
        $symbol = new Symbol(1, 2, new NullLexeme());
        self::assertSame(2, $symbol->getCode());
    }

    public function testGetLexeme_Constructed_ReturnsSelfInstance(): void
    {
        $symbol = new Symbol(1, 2, new NullLexeme());
        self::assertSame($symbol, $symbol->getLexeme());
    }

    public function testGetSymbols_Constructed_ReturnsSelfInList(): void
    {
        $symbol = new Symbol(1, 2, new NullLexeme());
        self::assertSame([$symbol], $symbol->getSymbols());
    }

    public function testGetConstituentLexeme_ConstructedWithLexeme_ReturnsSameInstance(): void
    {
        $lexeme = $this->createMock(LexemeInterface::class);
        $symbol = new Symbol(1, 2, $lexeme);
        self::assertSame($lexeme, $symbol->getConstituentLexeme());
    }

    public function testGetStartOffsets_ConstituentLexemeHasNoStartOffsets_ReturnsSymbolOffsetInList(): void
    {
        $lexeme = $this->createMock(LexemeInterface::class);
        $symbol = new Symbol(1, 2, $lexeme);
        $lexeme
            ->method('getStartOffsets')
            ->willReturn([]);
        self::assertSame([1], $symbol->getStartOffsets());
    }

    public function testGetStartOffsets_ConstituentLexemeHasStartOffsets_AppendsLexemeOffsetsToSymbolOffset(): void
    {
        $lexeme = $this->createMock(LexemeInterface::class);
        $symbol = new Symbol(1, 2, $lexeme);
        $lexeme
            ->method('getStartOffsets')
            ->willReturn([3, 4]);
        self::assertSame([1, 3, 4], $symbol->getStartOffsets());
    }

    public function testGetFinishOffsets_ConstituentLexemeHasNoFinishOffsets_ReturnsSymbolOffsetInList(): void
    {
        $lexeme = $this->createMock(LexemeInterface::class);
        $symbol = new Symbol(1, 2, $lexeme);
        $lexeme
            ->method('getFinishOffsets')
            ->willReturn([]);
        self::assertSame([1], $symbol->getFinishOffsets());
    }

    public function testGetFinishOffsets_ConstituentLexemeHasFinishOffsets_AppendsLexemeOffsetsToSymbolOffset(): void
    {
        $lexeme = $this->createMock(LexemeInterface::class);
        $symbol = new Symbol(1, 2, $lexeme);
        $lexeme
            ->method('getFinishOffsets')
            ->willReturn([3, 4]);
        self::assertSame([1, 3, 4], $symbol->getFinishOffsets());
    }
}
