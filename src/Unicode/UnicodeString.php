<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Unicode;

use IntlChar;

use function array_map;
use function chr;
use function implode;

/**
 * @psalm-immutable
 */
final class UnicodeString implements StringInterface
{

    private const MIN_CHAR = 0x00;

    private const MAX_ASCII_CHAR = 0x7F;

    private const MAX_UNICODE_CHAR = 0x10FFFF;

    /**
     * @var int[]
     * @psalm-var array<int, int>
     */
    private $characters = [];

    public function __construct(int ...$characters)
    {
        foreach ($characters as $character) {
            if ($character > self::MAX_UNICODE_CHAR || $character < self::MIN_CHAR) {
                throw new Exception\NonUnicodeCharacterException($character);
            }
            $this->characters[] = $character;
        }
    }

    /**
     * @return int[]
     * @psalm-return array<int, int>
     * @psalm-pure
     */
    public function asCharacters(): array
    {
        return $this->characters;
    }

    /**
     * @return string
     * @psalm-pure
     */
    public function asAscii(): string
    {
        return implode(array_map([$this, 'asciiChr'], $this->characters));
    }

    /**
     * @param int $character
     * @return string
     * @psalm-pure
     */
    private function asciiChr(int $character): string
    {
        if ($character > self::MAX_ASCII_CHAR) {
            throw new Exception\NonAsciiCharacterException($character);
        }

        return chr($character);
    }

    /**
     * @return string
     * @psalm-pure
     */
    public function asUtf8(): string
    {
        return implode('', array_map([IntlChar::class, 'chr'], $this->characters));
    }
}
