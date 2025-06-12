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

class IntegerSchema extends AbstractJsonSchema
{
    protected ?int $multipleOf = null;

    protected ?int $minimum = null;

    protected ?int $exclusiveMinimum = null;

    protected ?int $maximum = null;

    protected ?int $exclusiveMaximum = null;

    public function setMultipleOf(int $multipleOf): static
    {
        if ($multipleOf <= 0) {
            throw new \InvalidArgumentException('Multiple of must be greater than 0');
        }
        $this->multipleOf = $multipleOf;
        return $this;
    }

    public function setMinimum(int $minimum): static
    {
        $this->minimum = $minimum;
        return $this;
    }

    public function setExclusiveMinimum(int $exclusiveMinimum): static
    {
        $this->exclusiveMinimum = $exclusiveMinimum;
        return $this;
    }

    public function setMaximum(int $maximum): static
    {
        $this->maximum = $maximum;
        return $this;
    }

    public function setExclusiveMaximum(int $exclusiveMaximum): static
    {
        $this->exclusiveMaximum = $exclusiveMaximum;
        return $this;
    }

    public function toArray(): array|bool
    {
        return $this->applyProperties(
            [
                'type' => 'integer',
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
                // integer
                'multipleOf',
                'minimum',
                'exclusiveMinimum',
                'maximum',
                'exclusiveMaximum',
            ],
        );
    }
}
