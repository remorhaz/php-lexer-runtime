<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token;

/**
 * @psalm-immutable
 */
final class AttributeCollection implements AttributeCollectionInterface
{

    /**
     * @var AttributeInterface[]
     * @psalm-var array<string,AttributeInterface>
     */
    private $attributeMap = [];

    /**
     * @param AttributeInterface[] $attributeMap
     * @psalm-param array<string,AttributeInterface> $attributeMap
     */
    public function __construct(array $attributeMap = [])
    {
        $this->attributeMap = $attributeMap;
    }

    /**
     * @param string $name
     * @return AttributeInterface
     * @psalm-pure
     */
    public function get(string $name): AttributeInterface
    {
        if (isset($this->attributeMap[$name])) {
            return $this->attributeMap[$name];
        }

        throw new Exception\AttributeNotFoundException($name);
    }

    /**
     * @param string $name
     * @return bool
     * @psalm-pure
     */
    public function has(string $name): bool
    {
        return isset($this->attributeMap[$name]);
    }
}
