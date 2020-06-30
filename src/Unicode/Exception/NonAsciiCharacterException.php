<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Unicode\Exception;

use RuntimeException;
use Throwable;

use function dechex;
use function strtoupper;

final class NonAsciiCharacterException extends RuntimeException implements ExceptionInterface
{

    /**
     * @var int
     */
    private $character;

    public function __construct(int $character, Throwable $previous = null)
    {
        $this->character = $character;
        parent::__construct($this->buildMessage(), 0, $previous);
    }

    private function buildMessage(): string
    {
        $hexCode = strtoupper(dechex($this->character));

        return "Character 0x{$hexCode} is not in ASCII range";
    }

    public function getCharacter(): int
    {
        return $this->character;
    }
}
