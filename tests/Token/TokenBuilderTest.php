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

    public function testBuild_IntegerAttributeValueSet_ReturnsTokenWithSameAttributeValue(): void
    {
        $lexeme = $this->createMock(LexemeInterface::class);
        $builder = new TokenBuilder(1, 2, $lexeme);
        $builder->setIntegerAttribute('a', 3);
        self::assertSame(3, $builder->build()->getAttributes()->get('a')->asInteger());
    }

    public function testSetIntegerAttribute_Always_ReturnsSelfInstance(): void
    {
        $lexeme = $this->createMock(LexemeInterface::class);
        $builder = new TokenBuilder(1, 2, $lexeme);
        self::assertSame($builder, $builder->setIntegerAttribute('a', 3));
    }

    /**
     * @param bool $attributeValue
     * @param bool $expectedValue
     * @dataProvider providerBooleanAttribute
     */
    public function testBuild_BooleanAttributeValueSet_ReturnsTokenWithSameAttributeValue(
        bool $attributeValue,
        bool $expectedValue
    ): void {
        $lexeme = $this->createMock(LexemeInterface::class);
        $builder = new TokenBuilder(1, 2, $lexeme);
        $builder->setBooleanAttribute('a', $attributeValue);
        self::assertSame($expectedValue, $builder->build()->getAttributes()->get('a')->asBoolean());
    }

    public function providerBooleanAttribute(): array
    {
        return [
            'False' => [false, false],
            'True' => [true, true],
        ];
    }

    public function testSetBooleanAttribute_Always_ReturnsSelfInstance(): void
    {
        $lexeme = $this->createMock(LexemeInterface::class);
        $builder = new TokenBuilder(1, 2, $lexeme);
        self::assertSame($builder, $builder->setBooleanAttribute('a', true));
    }

    public function testBuild_AsciiAttributeValueSet_ReturnsTokenWithSameAttributeAsciiValue(): void
    {
        $lexeme = $this->createMock(LexemeInterface::class);
        $builder = new TokenBuilder(1, 2, $lexeme);
        $builder->setAsciiAttribute('a', 'b');
        self::assertSame('b', $builder->build()->getAttributes()->get('a')->asString()->asAscii());
    }

    public function testSetAsciiAttribute_Always_ReturnsSelfInstance(): void
    {
        $lexeme = $this->createMock(LexemeInterface::class);
        $builder = new TokenBuilder(1, 2, $lexeme);
        self::assertSame($builder, $builder->setAsciiAttribute('a', 'b'));
    }

    public function testBuild_EmptyUnicodeAttributeValueSet_ReturnsTokenWithEmptyAttributeCharacters(): void
    {
        $lexeme = $this->createMock(LexemeInterface::class);
        $builder = new TokenBuilder(1, 2, $lexeme);
        $builder->setUnicodeAttribute('a');
        self::assertSame([], $builder->build()->getAttributes()->get('a')->asString()->asCharacters());
    }

    public function testBuild_UnicodeAttributeValueSet_ReturnsTokenWithSameAttributeCharacters(): void
    {
        $lexeme = $this->createMock(LexemeInterface::class);
        $builder = new TokenBuilder(1, 2, $lexeme);
        $builder->setUnicodeAttribute('a', 3, 4);
        self::assertSame([3, 4], $builder->build()->getAttributes()->get('a')->asString()->asCharacters());
    }

    public function testSetUnicodeAttribute_Always_ReturnsSelfInstance(): void
    {
        $lexeme = $this->createMock(LexemeInterface::class);
        $builder = new TokenBuilder(1, 2, $lexeme);
        self::assertSame($builder, $builder->setUnicodeAttribute('a'));
    }

    public function testBuild_SymbolCodeSet_ReturnsTokenWithSameSymbolCodeAttribute(): void
    {
        $lexeme = $this->createMock(LexemeInterface::class);
        $builder = new TokenBuilder(1, 2, $lexeme);
        $builder->setSymbolCode(3);
        self::assertSame(3, $builder->build()->getAttributes()->get('symbol.code')->asInteger());
    }

    public function testBuild_SymbolCodeNotSet_ReturnsTokenWithoutSymbolCodeAttribute(): void
    {
        $lexeme = $this->createMock(LexemeInterface::class);
        $builder = new TokenBuilder(1, 2, $lexeme);
        self::assertFalse($builder->build()->getAttributes()->has('symbol.code'));
    }

    public function testSetSymbolCode_Always_ReturnsSelfInstance(): void
    {
        $lexeme = $this->createMock(LexemeInterface::class);
        $builder = new TokenBuilder(1, 2, $lexeme);
        self::assertSame($builder, $builder->setSymbolCode(3));
    }
}
