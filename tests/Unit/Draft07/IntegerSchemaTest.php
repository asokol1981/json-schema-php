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
use ASokol1981\JsonSchema\Draft07\IntegerSchema;
use PHPUnit\Framework\Attributes\DataProvider;

class IntegerSchemaTest extends AbstractJsonSchemaTestCase
{
    protected function getSchema(): AbstractJsonSchema
    {
        return new IntegerSchema();
    }

    public static function provider(): array
    {
        return [
            'default' => [
                fn(IntegerSchema $schema) => $schema,
                ['type' => 'integer'],
            ],
            'multiple_of' => [
                fn(IntegerSchema $schema) => $schema->setMultipleOf(1),
                ['type' => 'integer', 'multipleOf' => 1],
            ],
            'minimum' => [
                fn(IntegerSchema $schema) => $schema->setMinimum(1),
                ['type' => 'integer', 'minimum' => 1],
            ],
            'exclusive_minimum' => [
                fn(IntegerSchema $schema) => $schema->setExclusiveMinimum(1),
                ['type' => 'integer', 'exclusiveMinimum' => 1],
            ],
            'maximum' => [
                fn(IntegerSchema $schema) => $schema->setMaximum(1),
                ['type' => 'integer', 'maximum' => 1],
            ],
            'exclusive_maximum' => [
                fn(IntegerSchema $schema) => $schema->setExclusiveMaximum(1),
                ['type' => 'integer', 'exclusiveMaximum' => 1],
            ],
            'all' => [
                fn(IntegerSchema $schema) => $schema
                    // common
                    ->setId('id')
                    ->setSchema('schema')
                    ->setComment('comment')
                    ->setTitle('title')
                    ->setDescription('description')
                    ->setDefault('default')
                    ->setExamples(['examples'])
                    ->setReadOnly(true)
                    ->setWriteOnly(true)
                    ->setDeprecated(true)
                    // integer
                    ->setMultipleOf(1)
                    ->setMinimum(2)
                    ->setExclusiveMinimum(3)
                    ->setMaximum(4)
                    ->setExclusiveMaximum(5),
                [
                    'type' => 'integer',
                    // common
                    '$id' => 'id',
                    '$schema' => 'schema',
                    '$comment' => 'comment',
                    'title' => 'title',
                    'description' => 'description',
                    'default' => 'default',
                    'examples' => ['examples'],
                    'readOnly' => true,
                    'writeOnly' => true,
                    'deprecated' => true,
                    // integer
                    'multipleOf' => 1,
                    'minimum' => 2,
                    'exclusiveMinimum' => 3,
                    'maximum' => 4,
                    'exclusiveMaximum' => 5,
                ],
            ],
        ];
    }

    #[DataProvider('provider')]
    public function test(\Closure $callback, array $expected)
    {
        $schema = new IntegerSchema();
        $callback($schema);

        $this->assertSame($expected, $schema->toArray());
    }

    public static function exception_provider(): array
    {
        return [
            'multiple_of' => [
                fn(IntegerSchema $schema) => $schema->setMultipleOf(-1),
            ],
        ];
    }

    #[DataProvider('exception_provider')]
    public function test_exception(\Closure $callback)
    {
        $schema = new IntegerSchema();

        $this->expectException(\InvalidArgumentException::class);
        $callback($schema);
    }
}
