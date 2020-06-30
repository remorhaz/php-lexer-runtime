<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token;

use function array_shift;
use function array_unshift;
use function count;
use function is_string;

final class MatcherSelector implements MatcherSelectorInterface
{

    /**
     * @var MatcherInterface[]
     * @psalm-var array<string,MatcherInterface>
     */
    private $matchers = [];

    /**
     * @var string[]
     * @psalm-var array<int,string>
     */
    private $matcherKeys = [];

    /**
     * @param MatcherInterface[] $matchers
     * @psalm-param array<array-key, MatcherInterface> $matchers
     * @param string|null        $startMatcherKey
     */
    public function __construct(array $matchers, ?string $startMatcherKey = null)
    {
        if (empty($matchers)) {
            throw new Exception\MatchersNotFoundException();
        }
        foreach ($matchers as $matcherKey => $matcher) {
            if (!is_string($matcherKey)) {
                throw new Exception\InvalidMatcherKeyException($startMatcherKey);
            }
            $this->matchers[$matcherKey] = $matcher;
            if (!isset($startMatcherKey)) {
                $startMatcherKey = $matcherKey;
            }
        }

        $this->setMatcher($startMatcherKey);
    }

    /**
     * @param string $matcherKey
     * @return MatcherInterface
     * @psalm-pure
     */
    private function getMatcherByKey(string $matcherKey): MatcherInterface
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
     * @return MatcherInterface
     * @psalm-pure
     */
    public function getMatcher(): MatcherInterface
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
