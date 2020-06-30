<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\Unicode;

use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\Unicode\Exception\NonAsciiCharacterException;
use Remorhaz\Lexer\Runtime\Unicode\Exception\NonUnicodeCharacterException;
use Remorhaz\Lexer\Runtime\Unicode\UnicodeString;

/**
 * @covers \Remorhaz\Lexer\Runtime\Unicode\UnicodeString
 */
class UnicodeStringTest extends TestCase
{

    /**
     * @param array $characters
     * @dataProvider providerNonUnicodeCharacters
     */
    public function testConstruct_NonUnicodeCharacter_ThrowsException(array $characters): void
    {
        $this->expectException(NonUnicodeCharacterException::class);
        new UnicodeString(...$characters);
    }

    public function providerNonUnicodeCharacters(): array
    {
        return [
            'Negative character' => [[-1]],
            'Positive character above range' => [[0x110000]],
        ];
    }

    /**
     * @param array $characters
     * @param array $expectedValue
     * @dataProvider providerAsCharacters
     */
    public function testAsCharacters_ConstructedWithCharacters_ReturnsSameCharacters(
        array $characters,
        array $expectedValue
    ): void {
        $string = new UnicodeString(...$characters);
        self::assertSame($expectedValue, $string->asCharacters());
    }

    public function providerAsCharacters(): array
    {
        return [
            'No characters' => [[], []],
            'Single character' => [[0x00], [0x00]],
            'Two characters' => [[0x00, 0x10FFFF], [0x00, 0x10FFFF]],
        ];
    }

    public function testAsAscii_CharacterOutOfRange_ThrowsException(): void
    {
        $string = new UnicodeString(0x80);
        $this->expectException(NonAsciiCharacterException::class);
        $string->asAscii();
    }

    /**
     * @param array $characters
     * @param string $expectedValue
     * @dataProvider providerAsAscii
     */
    public function testAsAscii_CharactersInRange_ReturnsMatchingString(array $characters, string $expectedValue): void
    {
        $string = new UnicodeString(...$characters);
        self::assertSame($expectedValue, $string->asAscii());
    }

    public function providerAsAscii(): array
    {
        return [
            'No characters' => [[], ''],
            'Single character' => [[0x61], 'a'],
            'Two range border characters' => [[0x00, 0x7F], "\x00\x7F"],
        ];
    }

    /**
     * @param array $characters
     * @param string $expectedValue
     * @dataProvider providerAsUtf8
     */
    public function testAsUtf8_CharactersInRange_ReturnsMatchingString(array $characters, string $expectedValue): void
    {
        $string = new UnicodeString(...$characters);
        self::assertSame($expectedValue, $string->asUtf8());
    }

    public function providerAsUtf8(): array
    {
        return [
            'No characters' => [[], ''],
            'Single ASCII character' => [[0x61], 'a'],
            'Non-ASCII sequence' => [[0x0633, 0x0644, 0x0627, 0x0645], 'سلام'],
            'Two range border characters' => [[0x00, 0x10FFFF], "\u{00}\u{10FFFF}"],
        ];
    }
}
