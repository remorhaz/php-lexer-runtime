<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\Token;

use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\Token\AttributeCollection;
use Remorhaz\Lexer\Runtime\Token\AttributeCollectionInterface;
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

    public function testGetAttributes_ConstructedWithAttributes_ReturnsSameInstance(): void
    {
        $lexeme = $this->createMock(LexemeInterface::class);
        $attributes = $this->createMock(AttributeCollectionInterface::class);
        $token = new Token(1, 2, $lexeme, $attributes);
        self::assertSame($attributes, $token->getAttributes());
    }

    public function testGetAttributes_ConstructedWithoutAttribute_ReturnsAttributesCollectionInstance(): void
    {
        $lexeme = $this->createMock(LexemeInterface::class);
        $token = new Token(1, 2, $lexeme);
        self::assertInstanceOf(AttributeCollection::class, $token->getAttributes());
    }

    public function testIsFinal_ConstructedWithEoiId_ReturnsTrue(): void
    {
        $token = new Token(0, 1, new NullLexeme());
        self::assertTrue($token->isFinal());
    }

    public function testIsFinal_ConstructedWithNonEoiId_ReturnsFalse(): void
    {
        $token = new Token(1, 2, new NullLexeme());
        self::assertFalse($token->isFinal());
    }

    public function testCreateEoi_Always_ReturnsTokenWithEoiId(): void
    {
        $token = Token::createEoi(1, new NullLexeme());
        self::assertSame(0, $token->getId());
    }

    public function testCreateEoi_GivenLexeme_ReturnsTokenWithSameLexeme(): void
    {
        $lexeme = new NullLexeme();
        $token = Token::createEoi(1, $lexeme);
        self::assertSame($lexeme, $token->getLexeme());
    }

    public function testCreateEoi_GivenOffset_ReturnsTokenWithSameOffset(): void
    {
        $token = Token::createEoi(1, new NullLexeme());
        self::assertSame(1, $token->getOffset());
    }

    public function testCreateEoi_AttributesNotGiven_ReturnsTokenWithAttributeCollectionInstance(): void
    {
        $token = Token::createEoi(1, new NullLexeme());
        self::assertInstanceOf(AttributeCollection::class, $token->getAttributes());
    }

    public function testCreateEoi_GivenAttributes_ReturnsTokenWithSameAttributesInstance(): void
    {
        $attributes = new AttributeCollection();
        $token = Token::createEoi(1, new NullLexeme(), $attributes);
        self::assertSame($attributes, $token->getAttributes());
    }
}
