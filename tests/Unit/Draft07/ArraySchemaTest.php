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
use ASokol1981\JsonSchema\Draft07\ArraySchema;
use ASokol1981\JsonSchema\Draft07\BooleanSchema;
use ASokol1981\JsonSchema\Draft07\FalseSchema;
use ASokol1981\JsonSchema\Draft07\IntegerSchema;
use ASokol1981\JsonSchema\Draft07\JsonSchemaInterface;
use ASokol1981\JsonSchema\Draft07\StringSchema;
use ASokol1981\JsonSchema\Draft07\TrueSchema;
use PHPUnit\Framework\Attributes\DataProvider;

class ArraySchemaTest extends AbstractJsonSchemaTestCase
{
    protected function getSchema(): AbstractJsonSchema
    {
        return new ArraySchema(new StringSchema());
    }

    public static function provider(): array
    {
        return [
            'default' => [
                new StringSchema(),
                fn(ArraySchema $schema) => $schema,
                [
                    'type' => 'array',
                    'items' => [
                        'type' => 'string',
                    ],
                ],
            ],
            'bool' => [
                true,
                fn(ArraySchema $schema) => $schema,
                [
                    'type' => 'array',
                    'items' => true,
                ],
            ],
            'array_bool' => [
                [true],
                fn(ArraySchema $schema) => $schema,
                [
                    'type' => 'array',
                    'items' => [true],
                ],
            ],
            'tuple' => [
                [new IntegerSchema(), new StringSchema(), new BooleanSchema()],
                fn(ArraySchema $schema) => $schema,
                [
                    'type' => 'array',
                    'items' => [
                        ['type' => 'integer'],
                        ['type' => 'string'],
                        ['type' => 'boolean'],
                    ],
                ],
            ],
            'min_items' => [
                new StringSchema(),
                fn(ArraySchema $schema) => $schema->setMinItems(5),
                [
                    'type' => 'array',
                    'items' => [
                        'type' => 'string',
                    ],
                    'minItems' => 5,
                ],
            ],
            'max_items' => [
                new StringSchema(),
                fn(ArraySchema $schema) => $schema->setMaxItems(5),
                [
                    'type' => 'array',
                    'items' => [
                        'type' => 'string',
                    ],
                    'maxItems' => 5,
                ],
            ],
            'unique_items' => [
                new StringSchema(),
                fn(ArraySchema $schema) => $schema->setUniqueItems(true),
                [
                    'type' => 'array',
                    'items' => [
                        'type' => 'string',
                    ],
                    'uniqueItems' => true,
                ],
            ],
            'contains' => [
                new StringSchema(),
                fn(ArraySchema $schema) => $schema->setContains(new IntegerSchema()),
                [
                    'type' => 'array',
                    'items' => [
                        'type' => 'string',
                    ],
                    'contains' => [
                        'type' => 'integer',
                    ],
                ],
            ],
            'contains_bool' => [
                new StringSchema(),
                fn(ArraySchema $schema) => $schema->setContains(true),
                [
                    'type' => 'array',
                    'items' => [
                        'type' => 'string',
                    ],
                    'contains' => true,
                ],
            ],
            'additional_items' => [
                new StringSchema(),
                fn(ArraySchema $schema) => $schema->setAdditionalItems(new IntegerSchema()),
                [
                    'type' => 'array',
                    'items' => [
                        'type' => 'string',
                    ],
                    'additionalItems' => [
                        'type' => 'integer',
                    ],
                ],
            ],
            'additional_items_bool' => [
                new StringSchema(),
                fn(ArraySchema $schema) => $schema->setAdditionalItems(true),
                [
                    'type' => 'array',
                    'items' => [
                        'type' => 'string',
                    ],
                    'additionalItems' => true,
                ],
            ],
            'all' => [
                new StringSchema(),
                fn(ArraySchema $schema) => $schema
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
                    // array
                    ->setMinItems(5)
                    ->setMaxItems(5)
                    ->setUniqueItems(true)
                    ->setContains(new IntegerSchema())
                    ->setAdditionalItems(new IntegerSchema()),
                [
                    'type' => 'array',
                    'items' => [
                        'type' => 'string',
                    ],
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
                    // array
                    'minItems' => 5,
                    'maxItems' => 5,
                    'uniqueItems' => true,
                    'contains' => [
                        'type' => 'integer',
                    ],
                    'additionalItems' => [
                        'type' => 'integer',
                    ],
                ],
            ],
        ];
    }

    #[DataProvider('provider')]
    public function test(JsonSchemaInterface|array|bool $items, \Closure $callback, array $expected)
    {
        $schema = new ArraySchema($items);
        $callback($schema);

        $this->assertSame($expected, $schema->toArray());
    }

    public static function exception_provider(): array
    {
        return [
            'items_as_array' => [
                ['wrong'],
                fn(ArraySchema $schema) => $schema,
            ],
            'min_items' => [
                new StringSchema(),
                fn(ArraySchema $schema) => $schema->setMinItems(-1),
            ],
            'max_items' => [
                new StringSchema(),
                fn(ArraySchema $schema) => $schema->setMaxItems(-1),
            ],
        ];
    }

    #[DataProvider('exception_provider')]
    public function test_exception(mixed $items, \Closure $callback)
    {
        $this->expectException(\Throwable::class);
        $schema = new ArraySchema($items);
        $callback($schema);
    }
}
