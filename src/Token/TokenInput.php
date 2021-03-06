<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token;

use Iterator;
use IteratorAggregate;
use Remorhaz\Lexer\Runtime\IO\Exception;
use Remorhaz\Lexer\Runtime\IO\LexemeInterface;
use Remorhaz\Lexer\Runtime\IO\Symbol;
use Remorhaz\Lexer\Runtime\IO\SymbolInterface;
use Remorhaz\Lexer\Runtime\IO\SymbolReaderInterface;
use Throwable;

final class TokenInput implements IteratorAggregate, SymbolReaderInterface
{

    public const ATTRIBUTE_SYMBOL_CODE = 'symbol.code';

    /**
     * @var TokenReaderInterface
     */
    private $tokenReader;

    public function __construct(TokenReaderInterface $tokenReader)
    {
        $this->tokenReader = $tokenReader;
    }

    public function read(): SymbolInterface
    {
        $token = $this->tokenReader->read();
        $attribute = $token->getAttributes()->get(self::ATTRIBUTE_SYMBOL_CODE);
        try {
            return new Symbol($token->getOffset(), $attribute->asInteger(), $token->getLexeme());
        } catch (Throwable $e) {
            throw new Exception\InvalidSymbolCodeException($attribute, $e);
        }
    }

    /**
     * @return int
     * @psalm-pure
     */
    public function getOffset(): int
    {
        return $this->tokenReader->getOffset();
    }

    /**
     * @return bool
     * @psalm-pure
     */
    public function isFinished(): bool
    {
        return $this->tokenReader->isFinished();
    }

    /**
     * @return LexemeInterface
     * @psalm-pure
     */
    public function getEmptyLexeme(): LexemeInterface
    {
        return $this->tokenReader->getEmptyLexeme();
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
