<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\Unicode;

use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\Unicode\AsciiString;

/**
 * @covers \Remorhaz\Lexer\Runtime\Unicode\AsciiString
 */
class AsciiStringTest extends TestCase
{

    /**
     * @param string $text
     * @param array  $expectedValue
     * @dataProvider providerAsCharacters
     */
    public function testAsCharacters_ConstructedWithText_ReturnsMatchingValue(string $text, array $expectedValue): void
    {
        $string = new AsciiString($text);
        self::assertSame($expectedValue, $string->asCharacters());
    }

    public function providerAsCharacters(): array
    {
        return [
            'Empty text' => ['', []],
            'Single character' => ['a', [0x61]],
            'Two characters' => ['ab', [0x61, 0x62]],
        ];
    }

    public function testAsAscii_ConstructedWithText_ReturnsSameValue(): void
    {
        $string = new AsciiString('a');
        self::assertSame('a', $string->asAscii());
    }

    public function testAsUtf8_ConstructedWithText_ReturnsSameValue(): void
    {
        $string = new AsciiString('a');
        self::assertSame('a', $string->asUtf8());
    }
}
