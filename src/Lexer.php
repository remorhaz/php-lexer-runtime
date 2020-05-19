<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime;

use Remorhaz\Lexer\Runtime\IO\PreviewBuffer;
use Remorhaz\Lexer\Runtime\IO\SymbolReaderInterface;
use Remorhaz\Lexer\Runtime\Token\TokenMatcherInterface;
use Remorhaz\Lexer\Runtime\Token\TokenReader;
use Remorhaz\Lexer\Runtime\Token\TokenReaderInterface;
use Remorhaz\Lexer\Runtime\Token\MatcherSelector;

use function array_key_first;
use function is_string;

final class Lexer
{

    /**
     * @var MatcherSelector
     */
    private $matcherSelector;

    /**
     * @param TokenMatcherInterface[] $matchers
     * @psalm-param array<string,TokenMatcherInterface> $matchers
     * @param string|null             $startMatcherKey
     */
    public function __construct(array $matchers, ?string $startMatcherKey = null)
    {
        if (empty($matchers)) {
            throw new Exception\NoMatchersException();
        }
        if (!isset($startMatcherKey)) {
            $startMatcherKey = array_key_first($matchers);
        }
        if (!is_string($startMatcherKey)) {
            throw new Exception\InvalidMatcherKeyException($startMatcherKey);
        }
        $this->matcherSelector = new MatcherSelector($matchers, $startMatcherKey);
    }

    public function createTokenReader(SymbolReaderInterface $input): TokenReaderInterface
    {
        return new TokenReader(new PreviewBuffer($input), clone $this->matcherSelector);
    }
}
