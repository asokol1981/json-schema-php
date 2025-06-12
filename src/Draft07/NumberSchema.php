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

class NumberSchema extends AbstractJsonSchema
{
    protected ?float $multipleOf = null;

    protected ?float $minimum = null;

    protected ?float $exclusiveMinimum = null;

    protected ?float $maximum = null;

    protected ?float $exclusiveMaximum = null;

    public function setMultipleOf(float $multipleOf): static
    {
        if ($multipleOf <= 0) {
            throw new \InvalidArgumentException('Multiple of must be greater than 0');
        }
        $this->multipleOf = $multipleOf;
        return $this;
    }

    public function setMinimum(float $minimum): static
    {
        $this->minimum = $minimum;
        return $this;
    }

    public function setExclusiveMinimum(float $exclusiveMinimum): static
    {
        $this->exclusiveMinimum = $exclusiveMinimum;
        return $this;
    }

    public function setMaximum(float $maximum): static
    {
        $this->maximum = $maximum;
        return $this;
    }

    public function setExclusiveMaximum(float $exclusiveMaximum): static
    {
        $this->exclusiveMaximum = $exclusiveMaximum;
        return $this;
    }

    public function toArray(): array|bool
    {
        return $this->applyProperties(
            [
                'type' => 'number',
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
                // number
                'multipleOf',
                'minimum',
                'exclusiveMinimum',
                'maximum',
                'exclusiveMaximum',
            ],
        );
    }
}
