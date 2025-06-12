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

use ASokol1981\JsonSchema\Draft07\AbstractJsonSchema;
use ASokol1981\JsonSchema\Draft07\AbstractOfJsonSchema;
use ASokol1981\JsonSchema\Draft07\JsonSchemaInterface;

abstract class AbstractOfJsonSchemaTestCase extends AbstractJsonSchemaTestCase
{
    /**
     * @return AbstractOfJsonSchema
     */
    abstract protected function getSchema(): AbstractOfJsonSchema;

    /**
     * @param array<JsonSchemaInterface> $schemas
     * @return AbstractOfJsonSchema
     */
    abstract protected function getSchemaWithSchemas(array $schemas): AbstractOfJsonSchema;

    /**
     * @return string
     */
    abstract protected function getOf(): string;

    public function test_schemas(): void
    {
        $abstract = new class extends AbstractJsonSchema {
            public function toArray(): array|bool
            {
                return ['type' => 'abstract_of'];
            }
        };

        $schema = $this->getSchemaWithSchemas([$abstract]);

        $this->assertSame([
            $this->getOf() => [['type' => 'abstract_of']],
        ], $schema->toArray());
    }

    public function test_add_schema(): void
    {
        $abstract = new class extends AbstractJsonSchema {
            public function toArray(): array|bool
            {
                return ['type' => 'abstract_of'];
            }
        };

        $schema = $this->getSchema()->addSchema($abstract);

        $this->assertSame([
            $this->getOf() => [['type' => 'abstract_of']],
        ], $schema->toArray());
    }

    public function test_add_schema_as_bool(): void
    {
        $abstract = new class extends AbstractJsonSchema {
            public function toArray(): array|bool
            {
                return ['type' => 'abstract_of'];
            }
        };

        $schema = $this->getSchema()->addSchema(true);

        $this->assertSame([
            $this->getOf() => [true],
        ], $schema->toArray());
    }
}
