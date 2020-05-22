<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\IO;

use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\IO\EmptyLexeme;
use Remorhaz\Lexer\Runtime\IO\Exception\NonEmptyLexemeException;
use Remorhaz\Lexer\Runtime\IO\Lexeme;
use Remorhaz\Lexer\Runtime\IO\NullLexeme;
use Remorhaz\Lexer\Runtime\IO\Symbol;

/**
 * @covers \Remorhaz\Lexer\Runtime\IO\EmptyLexeme
 */
class EmptyLexemeTest extends TestCase
{

    public function testConstruct_NonEmptyConstituentLexeme_ThrowsException(): void
    {
        $constituentLexeme = new Lexeme(new Symbol(1, 2, new NullLexeme()));
        $this->expectException(NonEmptyLexemeException::class);
        new EmptyLexeme(3, $constituentLexeme);
    }

    /**
     * @param array $offsets
     * @param array $expectedOffsets
     * @dataProvider providerFromOffsets
     */
    public function testFromOffsets_GivenOffsets_ReturnsLexemeWithSameStartOffsets(
        array $offsets,
        array $expectedOffsets
    ): void {
        $lexeme = EmptyLexeme::fromOffsets(...$offsets);
        self::assertSame($expectedOffsets, $lexeme->getStartOffsets());
    }

    public function providerFromOffsets(): array
    {
        return [
            'No offsets' => [[], []],
            'Single offset' => [[1], [1]],
            'Two offsets' => [[1, 2], [1, 2]],
        ];
    }

    /**
     * @param array $offsets
     * @param array $expectedOffsets
     * @dataProvider providerFromOffsets
     */
    public function testFromOffsets_GivenOffsets_ReturnsLexemeWithSameFinishOffsets(
        array $offsets,
        array $expectedOffsets
    ): void {
        $lexeme = EmptyLexeme::fromOffsets(...$offsets);
        self::assertSame($expectedOffsets, $lexeme->getFinishOffsets());
    }

    public function testGetSymbols_Constructed_ReturnsEmptyList(): void
    {
        $lexeme = new EmptyLexeme(1, new NullLexeme());
        self::assertSame([], $lexeme->getSymbols());
    }

    public function testGetConstituentLexeme_ConstructedWithConstituentLexeme_ReturnsSameInstance(): void
    {
        $constituentLexeme = new NullLexeme();
        $lexeme = new EmptyLexeme(1, $constituentLexeme);
        self::assertSame($constituentLexeme, $lexeme->getConstituentLexeme());
    }
}
