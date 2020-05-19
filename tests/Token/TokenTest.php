<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\Token;

use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\Token\Exception\AttributeNotFoundException;
use Remorhaz\Lexer\Runtime\IO\LexemeInterface;
use Remorhaz\Lexer\Runtime\IO\NullLexeme;
use Remorhaz\Lexer\Runtime\Token\Token;

/**
 * @covers \Remorhaz\Lexer\Runtime\Token\Token
 */
class TokenTest extends TestCase
{

    public function testGetId_ConstructedWithId_ReturnsSameValue(): void
    {
        $lexeme = $this->createMock(LexemeInterface::class);
        $token = new Token(1, 2, $lexeme);
        self::assertSame(1, $token->getId());
    }

    public function testGetOffset_ConstructedWithId_ReturnsSameValue(): void
    {
        $lexeme = $this->createMock(LexemeInterface::class);
        $token = new Token(1, 2, $lexeme);
        self::assertSame(2, $token->getOffset());
    }

    public function testGetLexeme_ConstructedWithLexeme_ReturnsSameInstance(): void
    {
        $lexeme = $this->createMock(LexemeInterface::class);
        $token = new Token(1, 2, $lexeme);
        self::assertSame($lexeme, $token->getLexeme());
    }

    public function testGetAttribute_ConstructedWithAttribute_ReturnsMatchingValue(): void
    {
        $lexeme = $this->createMock(LexemeInterface::class);
        $token = new Token(1, 2, $lexeme, ['a' => 'b']);
        self::assertSame('b', $token->getAttribute('a'));
    }

    public function testGetAttribute_ConstructedWithoutAttribute_ThrowsException(): void
    {
        $lexeme = $this->createMock(LexemeInterface::class);
        $token = new Token(1, 2, $lexeme);
        $this->expectException(AttributeNotFoundException::class);
        $token->getAttribute('a');
    }

    public function testIsFinal_Always_ReturnsFalse(): void
    {
        $token = new Token(1, 2, new NullLexeme());
        self::assertFalse($token->isFinal());
    }
}
