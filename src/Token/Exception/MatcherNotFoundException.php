<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token\Exception;

use OutOfBoundsException;
use Throwable;

final class MatcherNotFoundException extends OutOfBoundsException implements ExceptionInterface
{

    /**
     * @var string
     */
    private $matcherKey;

    public function __construct(string $matcherKey, Throwable $previous = null)
    {
        $this->matcherKey = $matcherKey;
        parent::__construct("Matcher not found: {$this->matcherKey}", 0, $previous);
    }

    /**
     * @return string
     * @psalm-pure
     */
    public function getMatcherKey(): string
    {
        return $this->matcherKey;
    }
}
