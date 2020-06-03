<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token;

use function array_shift;
use function array_unshift;
use function count;

final class MatcherSelector implements MatcherSelectorInterface
{

    /**
     * @var TokenMatcherInterface[]
     * @psalm-var array<string,TokenMatcherInterface>
     */
    private $matchers;

    /**
     * @var string[]
     * @psalm-var array<int,string>
     */
    private $matcherKeys = [];

    /**
     * @param TokenMatcherInterface[] $matchers
     * @psalm-param array<string,TokenMatcherInterface> $matchers
     * @param string                  $startMatcherKey
     */
    public function __construct(array $matchers, string $startMatcherKey)
    {
        $this->matchers = $matchers;
        $this->setMatcher($startMatcherKey);
    }

    /**
     * @param string $matcherKey
     * @return TokenMatcherInterface
     * @psalm-pure
     */
    private function getMatcherByKey(string $matcherKey): TokenMatcherInterface
    {
        if (isset($this->matchers[$matcherKey])) {
            return $this->matchers[$matcherKey];
        }
        // @codeCoverageIgnoreStart
        throw new Exception\MatcherNotFoundException($matcherKey);
        // @codeCoverageIgnoreEnd
    }

    /**
     * {@inheritDoc}
     *
     * @return TokenMatcherInterface
     * @psalm-pure
     */
    public function getMatcher(): TokenMatcherInterface
    {
        if (isset($this->matcherKeys[0])) {
            return $this->getMatcherByKey($this->matcherKeys[0]);
        }

        // @codeCoverageIgnoreStart
        throw new Exception\MatcherKeyNotFoundException();
        // @codeCoverageIgnoreEnd
    }

    /**
     * {@inheritDoc}
     *
     * @param string $matcherKey
     */
    public function setMatcher(string $matcherKey): void
    {
        if (!isset($this->matchers[$matcherKey])) {
            throw new Exception\MatcherNotFoundException($matcherKey);
        }
        array_unshift($this->matcherKeys, $matcherKey);
    }

    /**
     * {@inheritDoc}
     */
    public function restoreMatcher(): void
    {
        if (count($this->matcherKeys) == 1) {
            throw new Exception\MatcherNotRestoredException();
        }
        array_shift($this->matcherKeys);
    }
}
