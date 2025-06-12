<?php

declare(strict_types=1);

/*
 * This file is part of Json Schema PHP.
 *
 * (c) Aleksei Sokolov <asokol.beststudio@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ASokol1981\JsonSchema\Draft07;

class ArraySchema extends AbstractJsonSchema
{
    /** @var JsonSchemaInterface|JsonSchemaInterface[] */
    protected JsonSchemaInterface|array $items;

    /** @var int|null */
    protected ?int $minItems = null;

    /** @var int|null */
    protected ?int $maxItems = null;

    /** @var bool|null */
    protected ?bool $uniqueItems = null;

    /** @var JsonSchemaInterface|null */
    protected ?JsonSchemaInterface $contains = null;

    /** @var JsonSchemaInterface|null */
    protected ?JsonSchemaInterface $additionalItems = null;

    /**
     * @param JsonSchemaInterface|array|bool $items
     */
    public function __construct(JsonSchemaInterface|array|bool $items)
    {
        if (is_bool($items)) {
            $items = $items ? new TrueSchema() : new FalseSchema();
        }
        if ($items instanceof JsonSchemaInterface) {
            $this->items = $items;
        } else {
            foreach($items as $item) {
                $this->addItem($item);
            }
        }
    }

    /**
     * @param JsonSchemaInterface|bool $item
     * @return $this
     */
    public function addItem(JsonSchemaInterface|bool $item): static
    {
        if (is_bool($item)) {
            $item = $item ? new TrueSchema() : new FalseSchema();
        }
        $this->items[] = $item;
        return $this;
    }

    /**
     * @param int $minItems
     * @return $this
     */
    public function setMinItems(int $minItems): static
    {
        if ($minItems < 0) {
            throw new \InvalidArgumentException('Property minItems must be greater than or equal to 0');
        }
        $this->minItems = $minItems;
        return $this;
    }

    /**
     * @param int $maxItems
     * @return $this
     */
    public function setMaxItems(int $maxItems): static
    {
        if ($maxItems < 0) {
            throw new \InvalidArgumentException('Property maxItems must be greater than or equal to 0');
        }
        $this->maxItems = $maxItems;
        return $this;
    }

    /**
     * @param bool $uniqueItems
     * @return $this
     */
    public function setUniqueItems(bool $uniqueItems): static
    {
        $this->uniqueItems = $uniqueItems;
        return $this;
    }

    /**
     * @param JsonSchemaInterface|bool $contains
     * @return $this
     */
    public function setContains(JsonSchemaInterface|bool $contains): static
    {
        if (is_bool($contains)) {
            $contains = $contains ? new TrueSchema() : new FalseSchema();
        }
        $this->contains = $contains;
        return $this;
    }

    /**
     * @param JsonSchemaInterface|bool $additionalItems
     * @return $this
     */
    public function setAdditionalItems(JsonSchemaInterface|bool $additionalItems): static
    {
        if (is_bool($additionalItems)) {
            $additionalItems = $additionalItems ? new TrueSchema() : new FalseSchema();
        }
        $this->additionalItems = $additionalItems;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array|bool
    {
        return $this->applyProperties(
            [
                'type' => 'array',
                'items' => ($this->items instanceof JsonSchemaInterface) ? $this->items->toArray() : array_map(fn($item) => $item->toArray(), $this->items),
            ],
            [
                // common
                '$id',
                '$schema',
                '$comment',
                'title',
                'description',
                'default',
                'examples',
                'readOnly',
                'writeOnly',
                'deprecated',
                // array
                'minItems',
                'maxItems',
                'uniqueItems',
                'contains',
                'additionalItems',
            ],
        );
    }
}
