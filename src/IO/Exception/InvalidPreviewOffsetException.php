<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\IO\Exception;

use OutOfRangeException;
use Throwable;

final class InvalidPreviewOffsetException extends OutOfRangeException implements ExceptionInterface
{

    /**
     * @var int
     */
    private $offset;

    public function __construct(int $offset, Throwable $previous = null)
    {
        $this->offset = $offset;
        parent::__construct("Invalid preview offset: {$this->offset}", 0, $previous);
    }

    /**
     * @return int
     * @psalm-pure
     */
    public function getOffset(): int
    {
        return $this->offset;
    }
}
