<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\IO\Exception;

use InvalidArgumentException;
use Remorhaz\Lexer\Runtime\IO\LexemeInterface;
use Throwable;

final class NonEmptyLexemeException extends InvalidArgumentException implements ExceptionInterface
{

    /**
     * @var LexemeInterface
     */
    private $lexeme;

    public function __construct(LexemeInterface $lexeme, Throwable $previous = null)
    {
        $this->lexeme = $lexeme;
        parent::__construct("Empty lexeme can't include non-empty one", 0, $previous);
    }

    /**
     * @return LexemeInterface
     * @psalm-pure
     */
    public function getLexeme(): LexemeInterface
    {
        return $this->lexeme;
    }
}
