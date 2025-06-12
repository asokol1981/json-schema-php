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

namespace ASokol1981\JsonSchema;

abstract class AbstractJsonSchema implements JsonSchemaInterface
{
    public function jsonSerialize(): array|bool
    {
        return $this->toArray();
    }
}
