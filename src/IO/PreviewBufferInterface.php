<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\IO;

interface PreviewBufferInterface
{

    public function getPreviewSymbol(): SymbolInterface;

    public function resetPreview(): void;

    public function previewNext(): void;

    public function previewPrevious(): void;

    /**
     * @return bool
     * @psalm-pure
     */
    public function isFinished(): bool;

    public function acceptLexeme(): LexemeInterface;

    /**
     * @return LexemeInterface
     * @psalm-pure
     */
    public function getEmptyLexeme(): LexemeInterface;
}
