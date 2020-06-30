<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token;

use Iterator;
use IteratorAggregate;
use Remorhaz\Lexer\Runtime\IO\EmptyLexeme;
use Remorhaz\Lexer\Runtime\IO\LexemeInterface;
use Remorhaz\Lexer\Runtime\IO\PreviewBufferInterface;

final class TokenReader implements IteratorAggregate, TokenReaderInterface
{

    /**
     * @var PreviewBufferInterface
     */
    private $previewBuffer;

    /**
     * @var MatcherSelectorInterface
     */
    private $matcherSelector;

    /**
     * @var int
     */
    private $offset = 0;

    /**
     * @var bool
     */
    private $isFinished = false;

    public function __construct(PreviewBufferInterface $previewBuffer, MatcherSelectorInterface $tokenContext)
    {
        $this->previewBuffer = $previewBuffer;
        $this->matcherSelector = $tokenContext;
    }

    /**
     * @return bool
     * @psalm-pure
     */
    public function isFinished(): bool
    {
        return $this->isFinished;
    }

    /**
     * @return int
     * @psalm-pure
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @return TokenInterface
     */
    public function read(): TokenInterface
    {
        if ($this->isFinished) {
            throw new Exception\UnexpectedEndOfInputException($this->getEmptyLexeme()->getStartOffsets());
        }

        if ($this->previewBuffer->isFinished()) {
            $this->isFinished = true;

            return Token::createEoi($this->offset, $this->previewBuffer->getEmptyLexeme());
        }

        do {
            $matcher = $this->matcherSelector->getMatcher();
            $matchResult = $matcher->match($this->offset, $this->previewBuffer, $this->matcherSelector);
        } while ($matchResult->shouldRepeat());
        $this->offset++;

        return $matchResult->getToken();
    }

    /**
     * @return LexemeInterface
     * @psalm-pure
     */
    public function getEmptyLexeme(): LexemeInterface
    {
        return new EmptyLexeme($this->offset, $this->previewBuffer->getEmptyLexeme());
    }

    /**
     * @return Iterator
     * @psalm-return Iterator<int, TokenInterface>
     */
    public function getIterator(): Iterator
    {
        while (!$this->isFinished()) {
            yield $this->getOffset() => $this->read();
        }
    }
}
