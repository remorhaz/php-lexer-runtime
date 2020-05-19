<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\IO;

use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\IO\NullLexeme;

/**
 * @covers \Remorhaz\Lexer\Runtime\IO\NullLexeme
 */
class NullLexemeTest extends TestCase
{

    public function testGetSymbols_Always_ReturnsEmptyList(): void
    {
        self::assertSame([], (new NullLexeme())->getSymbols());
    }

    public function testGetStartOffsets_Always_ReturnsEmptyList(): void
    {
        self::assertSame([], (new NullLexeme())->getStartOffsets());
    }

    public function testGetFinishOffsets_Always_ReturnsEmptyList(): void
    {
        self::assertSame([], (new NullLexeme())->getFinishOffsets());
    }

    public function testGetConstituentLexeme_Always_ReturnsSelfInstance(): void
    {
        $lexeme = new NullLexeme();
        self::assertSame($lexeme, $lexeme->getConstituentLexeme());
    }
}
