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

use ASokol1981\JsonSchema\AbstractJsonSchema as BaseAbstractJsonSchema;

class RefSchema extends BaseAbstractJsonSchema implements JsonSchemaInterface
{
    private string $ref;

    public function __construct(string $ref)
    {
        $this->ref = $ref;
    }

    public function toArray(): array|bool
    {
        return ['$ref' => $this->ref];
    }
}
