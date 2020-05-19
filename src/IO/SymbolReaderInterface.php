<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\IO;

interface SymbolReaderInterface extends ReaderInterface
{

    public function read(): SymbolInterface;
}
