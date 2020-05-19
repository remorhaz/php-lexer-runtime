<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token\Exception;

use RuntimeException;
use Throwable;

final class TokenNotMatchedException extends RuntimeException implements ExceptionInterface
{

    /**
     * @var int[]
     * @psalm-var array<int,int>
     */
    private $offsets;

    /**
     * @param int[]          $offsets
     * @psalm-param array<int,int> $offsets
     * @param Throwable|null $previous
     */
    public function __construct(array $offsets, Throwable $previous = null)
    {
        $this->offsets = $offsets;
        parent::__construct("Failed to match token", 0, $previous);
    }

    /**
     * @return int[]
     * @psalm-return array<int,int>
     */
    public function getOffsets(): array
    {
        return $this->offsets;
    }
}
