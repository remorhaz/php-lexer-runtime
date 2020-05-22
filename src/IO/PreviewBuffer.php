<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\IO;

use function array_slice;

final class PreviewBuffer implements PreviewBufferInterface
{

    /**
     * @var SymbolReaderInterface
     */
    private $input;

    /**
     * @var SymbolInterface[]
     * @psalm-var array<int,SymbolInterface>
     */
    private $buffer = [];

    /**
     * @var int
     */
    private $previewOffset;

    /**
     * @var int
     */
    private $tokenOffset;

    public function __construct(SymbolReaderInterface $input)
    {
        $this->input = $input;
        $this->tokenOffset = $input->getOffset();
        $this->previewOffset = $this->tokenOffset;
    }

    public function getPreviewSymbol(): SymbolInterface
    {
        if (!isset($this->buffer[$this->previewOffset])) {
            $this->buffer[$this->previewOffset] = $this->input->read();
        }

        return $this->buffer[$this->previewOffset];
    }

    public function resetPreview(): void
    {
        $this->previewOffset = $this->tokenOffset;
    }

    public function previewNext(): void
    {
        if (!isset($this->buffer[$this->previewOffset])) {
            $this->buffer[$this->previewOffset] = $this->input->read();
        }
        $this->previewOffset++;
    }

    public function previewPrevious(): void
    {
        if ($this->previewOffset == $this->tokenOffset) {
            throw new Exception\InvalidPreviewOffsetException($this->tokenOffset);
        }
        $this->previewOffset--;
    }

    /**
     * @return bool
     * @psalm-pure
     */
    public function isFinished(): bool
    {
        return !isset($this->buffer[$this->previewOffset]) && $this->input->isFinished();
    }

    public function acceptLexeme(): LexemeInterface
    {
        $length = $this->previewOffset - $this->tokenOffset;
        $lexeme = new Lexeme(...array_slice($this->buffer, $this->tokenOffset, $length));
        $this->tokenOffset = $this->previewOffset;

        return $lexeme;
    }

    /**
     * @return LexemeInterface
     * @psalm-pure
     */
    public function getEmptyLexeme(): LexemeInterface
    {
        if (isset($this->buffer[$this->previewOffset])) {
            $symbol = $this->buffer[$this->previewOffset];

            return EmptyLexeme::fromOffsets($this->previewOffset, ...$symbol->getLexeme()->getStartOffsets());
        }

        return new EmptyLexeme($this->previewOffset, $this->input->getEmptyLexeme());
    }
}
