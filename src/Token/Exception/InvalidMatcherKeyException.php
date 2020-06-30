<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token\Exception;

use DomainException;
use Throwable;

final class InvalidMatcherKeyException extends DomainException implements ExceptionInterface
{

    /**
     * @var mixed
     */
    private $matcherKey;

    /**
     * InvalidMatcherKeyException constructor.
     *
     * @param mixed          $matcherKey
     * @param Throwable|null $previous
     */
    public function __construct($matcherKey, Throwable $previous = null)
    {
        $this->matcherKey = $matcherKey;
        parent::__construct("Invalid matcher key", 0, $previous);
    }

    /**
     * @return mixed
     * @psalm-pure
     */
    public function getMatcherKey()
    {
        return $this->matcherKey;
    }
}
