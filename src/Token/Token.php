<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token;

use Remorhaz\Lexer\Runtime\IO\LexemeInterface;

/**
 * @psalm-immutable
 */
final class Token implements TokenInterface
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $offset;

    /**
     * @var LexemeInterface
     */
    private $lexeme;

    /**
     * @var AttributeCollectionInterface
     */
    private $attributes;

    /**
     * @param int                               $offset
     * @param LexemeInterface                   $lexeme
     * @param AttributeCollectionInterface|null $attributes
     * @return TokenInterface
     */
    public static function createEoi(
        int $offset,
        LexemeInterface $lexeme,
        ?AttributeCollectionInterface $attributes = null
    ): TokenInterface {
        return new self(TokenInterface::ID_EOI, $offset, $lexeme, $attributes ?? new AttributeCollection());
    }

    /**
     * Token constructor.
     *
     * @param int                               $id
     * @param int                               $offset
     * @param LexemeInterface                   $lexeme
     * @param AttributeCollectionInterface|null $attributes
     */
    public function __construct(
        int $id,
        int $offset,
        LexemeInterface $lexeme,
        ?AttributeCollectionInterface $attributes = null
    ) {
        $this->id = $id;
        $this->offset = $offset;
        $this->lexeme = $lexeme;
        $this->attributes = $attributes ?? new AttributeCollection();
    }

    /**
     * @return int
     * @psalm-pure
     */
    public function getId(): int
    {
        return $this->id;
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
    public function getLexeme(): LexemeInterface
    {
        return $this->lexeme;
    }

    /**
     * @return AttributeCollectionInterface
     * @psalm-pure
     */
    public function getAttributes(): AttributeCollectionInterface
    {
        return $this->attributes;
    }

    /**
     * @return bool
     * @psalm-pure
     */
    public function isFinal(): bool
    {
        return self::ID_EOI == $this->id;
    }
}
