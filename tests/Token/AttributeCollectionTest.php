<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\Token;

use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\Token\AttributeCollection;
use Remorhaz\Lexer\Runtime\Token\AttributeInterface;
use Remorhaz\Lexer\Runtime\Token\Exception\AttributeNotFoundException;

/**
 * @covers \Remorhaz\Lexer\Runtime\Token\AttributeCollection
 */
class AttributeCollectionTest extends TestCase
{

    public function testHas_ConstructedWithAttribute_ReturnsTrue(): void
    {
        $attributes = new AttributeCollection(['a' => $this->createMock(AttributeInterface::class)]);
        self::assertTrue($attributes->has('a'));
    }

    public function testHas_ConstructedWithoutAttribute_ReturnsTrue(): void
    {
        $attributes = new AttributeCollection();
        self::assertFalse($attributes->has('a'));
    }

    public function testGet_ConstructedWithAttribute_ReturnsSameInstance(): void
    {
        $attribute = $this->createMock(AttributeInterface::class);
        $attributes = new AttributeCollection(['a' => $attribute]);
        self::assertSame($attribute, $attributes->get('a'));
    }

    public function testGet_ConstructedWithoutAttribute_ThrowsException(): void
    {
        $attributes = new AttributeCollection();
        $this->expectException(AttributeNotFoundException::class);
        $attributes->get('a');
    }
}
