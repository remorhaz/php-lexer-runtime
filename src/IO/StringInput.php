<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\IO;

use Iterator;
use IteratorAggregate;

use function strlen;

final class StringInput implements IteratorAggregate, SymbolReaderInterface
{

    /**
     * @var string
     */
    private $data;

    /**
     * @var int
     */
    private $offset = 0;

    /**
     * @var int
     */
    private $length;

    public function __construct(string $data)
    {
        $this->data = $data;
        $this->length = strlen($data);
    }

    /**
     * @return bool
     * @psalm-pure
     */
    public function isFinished(): bool
    {
        return $this->length == $this->offset;
    }

    public function read(): SymbolInterface
    {
        if ($this->length == $this->offset) {
            throw new Exception\UnexpectedEndOfInputException($this->offset);
        }

        return new Symbol($this->offset, ord($this->data[$this->offset++]), new NullLexeme());
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
     * @return LexemeInterface
     * @psalm-pure
     */
    public function getEmptyLexeme(): LexemeInterface
    {
        return new EmptyLexeme($this->offset, new NullLexeme());
    }

    /**
     * @return Iterator
     * @psalm-return Iterator<int,SymbolInterface>
     */
    public function getIterator(): Iterator
    {
        while (!$this->isFinished()) {
            yield $this->getOffset() => $this->read();
        }
    }
}
