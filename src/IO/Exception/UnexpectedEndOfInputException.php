<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\IO\Exception;

use OutOfRangeException;
use Throwable;

final class UnexpectedEndOfInputException extends OutOfRangeException implements ExceptionInterface
{

    /**
     * @var int
     */
    private $offset;

    public function __construct(int $offset, Throwable $previous = null)
    {
        $this->offset = $offset;
        parent::__construct("Unexpected end of input at offset {$this->offset}", 0, $previous);
    }

    public function getOffset(): int
    {
        return $this->offset;
    }
}
