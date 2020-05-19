<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\IO;

use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\IO\Exception\EmptyLexemeException;
use Remorhaz\Lexer\Runtime\IO\Lexeme;
use Remorhaz\Lexer\Runtime\IO\LexemeInterface;
use Remorhaz\Lexer\Runtime\IO\NullLexeme;
use Remorhaz\Lexer\Runtime\IO\Symbol;
use Remorhaz\Lexer\Runtime\IO\SymbolInterface;

/**
 * @covers \Remorhaz\Lexer\Runtime\IO\Lexeme
 */
class LexemeTest extends TestCase
{

    public function testConstruct_NoSymbols_ThrowsException(): void
    {
        $this->expectException(EmptyLexemeException::class);
        new Lexeme();
    }

    public function testGetSymbols_ConstructedWithSymbols_ReturnsSameSymbols(): void
    {
        $firstSymbol = $this->createMock(SymbolInterface::class);
        $secondSymbol = $this->createMock(SymbolInterface::class);
        $lexeme = new Lexeme($firstSymbol, $secondSymbol);
        self::assertSame([$firstSymbol, $secondSymbol], $lexeme->getSymbols());
    }

    public function testGetStartOffsets_FirstSymbolLexemeHasStartOffsets_ReturnsSameValues(): void
    {
        $firstSymbol = $this->createMock(SymbolInterface::class);
        $firstSymbolLexeme = $this->createMock(LexemeInterface::class);
        $firstSymbol
            ->method('getLexeme')
            ->willReturn($firstSymbolLexeme);
        $firstSymbolLexeme
            ->method('getStartOffsets')
            ->willReturn([1, 2]);
        $secondSymbol = $this->createMock(SymbolInterface::class);
        $secondSymbolLexeme = $this->createMock(LexemeInterface::class);
        $secondSymbol
            ->method('getLexeme')
            ->willReturn($secondSymbolLexeme);
        $secondSymbolLexeme
            ->method('getStartOffsets')
            ->willReturn([3, 4]);
        $lexeme = new Lexeme($firstSymbol, $secondSymbol);
        self::assertSame([1, 2], $lexeme->getStartOffsets());
    }

    public function testGetFinishOffsets_LastSymbolLexemeHasFinishOffsets_ReturnsSameValues(): void
    {
        $firstSymbol = $this->createMock(SymbolInterface::class);
        $firstSymbolLexeme = $this->createMock(LexemeInterface::class);
        $firstSymbol
            ->method('getLexeme')
            ->willReturn($firstSymbolLexeme);
        $firstSymbolLexeme
            ->method('getFinishOffsets')
            ->willReturn([1, 2]);
        $secondSymbol = $this->createMock(SymbolInterface::class);
        $secondSymbolLexeme = $this->createMock(LexemeInterface::class);
        $secondSymbol
            ->method('getLexeme')
            ->willReturn($secondSymbolLexeme);
        $secondSymbolLexeme
            ->method('getFinishOffsets')
            ->willReturn([3, 4]);
        $lexeme = new Lexeme($firstSymbol, $secondSymbol);
        self::assertSame([3, 4], $lexeme->getFinishOffsets());
    }

    public function testGetConstituentLexeme_SymbolsHasConstituentLexemes_ReturnsContatenatedConstituentSymbols(): void
    {
        $firstSymbolFirstSubSymbol = new Symbol(0, 1, new NullLexeme());
        $firstSymbolSecondSubSymbol = new Symbol(1, 2, new NullLexeme());
        $firstSymbol = new Symbol(
            0,
            3,
            new Lexeme($firstSymbolFirstSubSymbol, $firstSymbolSecondSubSymbol)
        );
        $secondSymbolFirstSubSymbol = new Symbol(2, 4, new NullLexeme());
        $secondSymbolSecondSubSymbol = new Symbol(3, 5, new NullLexeme());
        $secondSymbol = new Symbol(
            1,
            6,
            new Lexeme($secondSymbolFirstSubSymbol, $secondSymbolSecondSubSymbol)
        );
        $lexeme = new Lexeme($firstSymbol, $secondSymbol);
        self::assertSame(
            [
                $firstSymbolFirstSubSymbol,
                $firstSymbolSecondSubSymbol,
                $secondSymbolFirstSubSymbol,
                $secondSymbolSecondSubSymbol,
            ],
            $lexeme->getConstituentLexeme()->getSymbols()
        );
    }
}
