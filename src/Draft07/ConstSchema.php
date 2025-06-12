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

class ConstSchema extends AbstractJsonSchema
{
    protected mixed $const;

    public function __construct(mixed $const)
    {
        $this->const = $const;
    }

    public function toArray(): array|bool
    {
        return $this->applyProperties(
            [
                'const' => $this->const,
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
            ],
        );
    }
}
