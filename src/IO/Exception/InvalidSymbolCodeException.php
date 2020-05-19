<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\IO\Exception;

use DomainException;
use Throwable;

final class InvalidSymbolCodeException extends DomainException implements ExceptionInterface
{

    /**
     * @var mixed
     */
    private $symbolCode;

    /**
     * @param mixed          $symbolCode
     * @param Throwable|null $previous
     */
    public function __construct($symbolCode, Throwable $previous = null)
    {
        $this->symbolCode = $symbolCode;
        parent::__construct("Invalid symbol code", 0, $previous);
    }

    /**
     * @return mixed
     * @psalm-pure
     */
    public function getSymbolCode()
    {
        return $this->symbolCode;
    }
}
