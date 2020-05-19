<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\Token;

use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\IO\LexemeInterface;
use Remorhaz\Lexer\Runtime\Token\TokenBuilder;

/**
 * @covers \Remorhaz\Lexer\Runtime\Token\TokenBuilder
 */
class TokenBuilderTest extends TestCase
{

    public function testBuild_ConstructedWithId_ReturnsTokenWithSameId(): void
    {
        $lexeme = $this->createMock(LexemeInterface::class);
        $builder = new TokenBuilder(1, 2, $lexeme);
        self::assertSame(1, $builder->build()->getId());
    }

    public function testBuild_ConstructedWithOffset_ReturnsTokenWithSameOffset(): void
    {
        $lexeme = $this->createMock(LexemeInterface::class);
        $builder = new TokenBuilder(1, 2, $lexeme);
        self::assertSame(2, $builder->build()->getOffset());
    }

    public function testBuild_ConstructedWithLexeme_ReturnsTokenWithSameLexemeInstance(): void
    {
        $lexeme = $this->createMock(LexemeInterface::class);
        $builder = new TokenBuilder(1, 2, $lexeme);
        self::assertSame($lexeme, $builder->build()->getLexeme());
    }

    public function testBuild_AttributeValueSet_ReturnsTokenWithSameAttributeValue(): void
    {
        $lexeme = $this->createMock(LexemeInterface::class);
        $builder = new TokenBuilder(1, 2, $lexeme);
        $builder->setAttribute('a', 'b');
        self::assertSame('b', $builder->build()->getAttribute('a'));
    }

    public function testSetAttribute_Always_ReturnsSelfInstance(): void
    {
        $lexeme = $this->createMock(LexemeInterface::class);
        $builder = new TokenBuilder(1, 2, $lexeme);
        self::assertSame($builder, $builder->setAttribute('a', 'b'));
    }
}
