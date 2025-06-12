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

namespace ASokol1981\JsonSchema\Tests\Unit\Draft07;

use ASokol1981\JsonSchema\Draft07\AbstractOfJsonSchema;
use ASokol1981\JsonSchema\Draft07\NotSchema;

class NotSchemaTest extends AbstractOfJsonSchemaTestCase
{
    protected function getSchema(): AbstractOfJsonSchema
    {
        return new NotSchema();
    }

    protected function getSchemaWithSchemas(array $schemas): AbstractOfJsonSchema
    {
        return new NotSchema($schemas);
    }

    protected function getOf(): string
    {
        return 'not';
    }
}
