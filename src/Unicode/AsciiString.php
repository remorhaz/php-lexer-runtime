<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Unicode;

use function array_map;
use function str_split;

/**
 * @psalm-immutable
 */
final class AsciiString implements StringInterface
{

    /**
     * @var string
     */
    private $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    /**
     * @return array
     * @psalm-return array<int, int>
     * @psalm-pure
     */
    public function asCharacters(): array
    {
        return '' == $this->text
            ? []
            : array_map('ord', str_split($this->text));
    }

    /**
     * @return string
     * @psalm-pure
     */
    public function asAscii(): string
    {
        return $this->text;
    }

    /**
     * @return string
     * @psalm-pure
     */
    public function asUtf8(): string
    {
        return $this->text;
    }
}
